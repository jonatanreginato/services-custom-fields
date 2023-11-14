<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Parser;

use Generator;
use Nuvemshop\CustomFields\Application\Api\Response\ApiResponse;
use Nuvemshop\CustomFields\Application\Api\Validation\Captures\Errors\ErrorAggregatorInterface;
use Nuvemshop\CustomFields\Application\Api\Validation\Captures\Errors\ErrorCodes;
use Nuvemshop\CustomFields\Application\Api\Validation\Captures\Errors\ErrorMessages;
use Nuvemshop\CustomFields\Application\Api\Validation\Captures\Errors\SimpleError;
use Nuvemshop\CustomFields\Application\Api\Validation\Exceptions\ApiInvalidQueryParametersException;
use Nuvemshop\CustomFields\Application\Api\Validation\Exceptions\MissingStoreIdException;
use Nuvemshop\CustomFields\Application\Api\Validation\Rules\DefaultQueryRules;
use Nuvemshop\CustomFields\Application\Api\Validation\Rules\QueryRulesInterface;

use function in_array;
use function is_string;

class QueryParser implements QueryParserInterface
{
    private ?QueryRulesInterface $queryRules = null;

    private mixed $identityParameter = null;

    private ?int $storeId = null;

    private array $parameters = [];

    private mixed $cachedIdentity = null;

    private ?array $cachedFilters = null;

    public function __construct(private readonly ErrorAggregatorInterface $errorAggregator)
    {
    }

    public function setQueryRules(QueryRulesInterface $queryRules): void
    {
        $this->queryRules = $queryRules;
    }

    protected function getQueryRules(): QueryRulesInterface
    {
        if ($this->queryRules === null) {
            $this->queryRules = new DefaultQueryRules();
        }

        return $this->queryRules;
    }

    public function parse(mixed $identity, int $storeId, array $parameters = []): void
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

    private function setIdentityParameter(mixed $value): void
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
