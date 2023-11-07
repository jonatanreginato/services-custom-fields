<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Validation\Parser;

use Generator;
use Nuvemshop\ApiTemplate\Application\Api\Exceptions\MissingStoreIdException;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Exceptions\ApiInvalidQueryParametersException;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Response\ApiResponse;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Errors\ErrorAggregatorInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Errors\ErrorCodes;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Errors\ErrorMessages;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Errors\SimpleError;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Rules\QueryRulesAggregatorInterface;

use function in_array;
use function is_string;

class QueryParser implements QueryParserInterface
{
    private ?QueryRulesAggregatorInterface $queryRules = null;

    private ?string $identityParameter = null;

    private ?int $storeId = null;

    private array $parameters = [];

    private mixed $cachedIdentity = null;

    private ?array $cachedFilters = null;

    public function __construct(
        private readonly ErrorAggregatorInterface $errorAggregator
    ) {
    }

    public function setQueryRules(QueryRulesAggregatorInterface $queryRules): void
    {
        $this->queryRules = $queryRules;
    }

    protected function getQueryRules(): QueryRulesAggregatorInterface
    {
        return $this->queryRules;
    }

    public function parse(?string $identity, int $storeId, array $parameters = []): void
    {
        $this->clear();
        $this->setIdentityParameter($identity);
        $this->setStoreId($storeId);
        $this->setParameters($parameters);

        if ($this->hasFilters()) {
            $this->getFilters();
        }

        $this->checkValidationQueueErrors();
    }

    private function clear(): void
    {
        $this->identityParameter = null;
        $this->storeId           = null;
        $this->parameters        = [];

        $this->cachedIdentity = null;
        $this->cachedFilters  = null;

        $this->errorAggregator->clear();
    }

    private function setIdentityParameter(?string $value): void
    {
        $this->identityParameter = $value;
    }

    private function setStoreId(int $storeId): void
    {
        if (!$storeId) {
            throw new MissingStoreIdException();
        }

        $this->storeId = $storeId;
    }

    private function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    public function getIdentity(): ?string
    {
        if ($this->cachedIdentity === null) {
            $this->cachedIdentity = $this->identityParameter;
        }

        return $this->cachedIdentity;
    }

    public function getStoreId(): int
    {
        return (int)$this->storeId;
    }

    public function hasFilters(): bool
    {
        return (bool)$this->parameters;
    }

    public function getFilters(): array
    {
        if ($this->cachedFilters === null) {
            $this->cachedFilters = $this->iterableToArray($this->getValidatedFilters());
        }

        return $this->cachedFilters;
    }

    private function getValidatedFilters(): iterable
    {
        foreach ($this->parameters as $field => $value) {
            if (!is_string($field) || empty($field) || !is_string($value) || empty($value)) {
                $this->errorAggregator->addQueryParameterApiError(
                    new SimpleError(
                        static::PARAM_FILTER,
                        $field,
                        ErrorCodes::INVALID_VALUE,
                        ErrorMessages::INVALID_VALUE,
                        []
                    )
                );
                $this->errorAggregator->addErrorStatus(ApiResponse::HTTP_BAD_REQUEST);

                $this->throwApiError();
            }

            if (
                $this->getQueryRules()->getAllowedFilters() &&
                !in_array($field, $this->getQueryRules()->getAllowedFilters(), true)
            ) {
                $this->errorAggregator->addQueryParameterApiError(
                    new SimpleError(
                        static::PARAM_FILTER,
                        $field,
                        ErrorCodes::UNKNOWN_ATTRIBUTE,
                        ErrorMessages::UNKNOWN_ATTRIBUTE,
                        []
                    )
                );
                $this->errorAggregator->addErrorStatus(ApiResponse::HTTP_BAD_REQUEST);

                $this->throwApiError();
            }

            yield $field => filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
    }

    protected function iterableToArray(iterable $iterable): array
    {
        $result = [];

        foreach ($iterable as $key => $value) {
            $result[$key] = $value instanceof Generator ? $this->iterableToArray($value) : $value;
        }

        return $result;
    }

    protected function checkValidationQueueErrors(): void
    {
        if (!$this->errorAggregator->count() && !$this->errorAggregator->getSimpleErrors()) {
            return;
        }

        foreach ($this->errorAggregator->getSimpleErrors() as $simpleError) {
            $this->errorAggregator->addQueryParameterApiError($simpleError);
        }

        $this->throwApiError();
    }

    private function throwApiError(): void
    {
        throw new ApiInvalidQueryParametersException(
            $this->errorAggregator,
            $this->errorAggregator->getErrorStatus()
        );
    }
}
