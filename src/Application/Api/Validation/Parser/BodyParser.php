<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Parser;

use Nuvemshop\CustomFields\Application\Api\Response\ApiResponse;
use Nuvemshop\CustomFields\Application\Api\Validation\Captures\Data\DataAggregatorInterface;
use Nuvemshop\CustomFields\Application\Api\Validation\Captures\Errors\ErrorAggregatorInterface;
use Nuvemshop\CustomFields\Application\Api\Validation\Captures\Errors\ErrorCodes;
use Nuvemshop\CustomFields\Application\Api\Validation\Captures\Errors\ErrorMessages;
use Nuvemshop\CustomFields\Application\Api\Validation\Captures\Errors\SimpleError;
use Nuvemshop\CustomFields\Application\Api\Validation\Exceptions\ApiInvalidBodyException;
use Nuvemshop\CustomFields\Application\Api\Validation\Rules\BodyRulesInterface;
use Nuvemshop\CustomFields\Application\Api\Validation\Rules\DefaultBodyRules;

class BodyParser implements BodyParserInterface
{
    private ?BodyRulesInterface $bodyRules = null;

    private array $bodyData = [];

    public function __construct(
        private readonly DataAggregatorInterface $captureAggregator,
        private readonly ErrorAggregatorInterface $errorAggregator
    ) {
    }

    public function setBodyRules(BodyRulesInterface $bodyRules): void
    {
        $this->bodyRules = $bodyRules;
    }

    protected function getBodyRules(): BodyRulesInterface
    {
        if ($this->bodyRules === null) {
            $this->bodyRules = new DefaultBodyRules();
        }

        return $this->bodyRules;
    }

    public function parse(string $requestBody): void
    {
        $this->clear();
        $this->setBodyData($requestBody);
        $this->parseAttributes();
        $this->checkValidationQueueErrors();
    }

    private function clear(): void
    {
        $this->bodyData = [];
        $this->captureAggregator->clear();
        $this->errorAggregator->clear();
    }

    private function setBodyData(string $requestBody): void
    {
        if (empty($requestBody) || ($this->bodyData = json_decode($requestBody, true)) === null) {
            $this->errorAggregator->addApiError(ErrorMessages::MSG_ERR_INVALID_JSON_DATA_IN_REQUEST);
            $this->errorAggregator->addErrorStatus(ApiResponse::HTTP_BAD_REQUEST);

            $this->throwApiError();
        }
    }

    private function parseAttributes(): void
    {
        foreach ($this->getBodyRules()->getRequiredAttributes() as $required) {
            if (!isset($this->bodyData[$required])) {
                $this->errorAggregator->addBodyApiError(
                    new SimpleError(
                        $required,
                        null,
                        ErrorCodes::REQUIRED,
                        ErrorMessages::REQUIRED,
                        []
                    ),
                    ApiResponse::HTTP_BAD_REQUEST
                );
                $this->errorAggregator->addErrorStatus(ApiResponse::HTTP_BAD_REQUEST);

                $this->throwApiError();
            }
        }

        foreach ($this->bodyData as $name => $value) {
            if (!is_string($name)) {
                $this->errorAggregator->addBodyApiError(
                    new SimpleError(
                        (string)$name,
                        $value,
                        ErrorCodes::INVALID_ATTRIBUTES,
                        ErrorMessages::INVALID_ATTRIBUTES,
                        []
                    ),
                    ApiResponse::HTTP_BAD_REQUEST
                );
                $this->errorAggregator->addErrorStatus(ApiResponse::HTTP_BAD_REQUEST);

                $this->throwApiError();
            }

            if (
                $this->getBodyRules()->getAllowedAttributes() &&
                !in_array($name, $this->getBodyRules()->getAllowedAttributes(), true)
            ) {
                $this->errorAggregator->addBodyApiError(
                    new SimpleError(
                        (string)$name,
                        $value,
                        ErrorCodes::UNKNOWN_ATTRIBUTE,
                        ErrorMessages::UNKNOWN_ATTRIBUTE,
                        []
                    )
                );
                $this->errorAggregator->addErrorStatus(ApiResponse::HTTP_BAD_REQUEST);

                $this->throwApiError();
            }

            $this->captureAggregator->remember($name, $value);
        }
    }

    protected function checkValidationQueueErrors(): void
    {
        if (!$this->errorAggregator->count() && !$this->errorAggregator->getSimpleErrors()) {
            return;
        }

        foreach ($this->errorAggregator->getSimpleErrors() as $simpleError) {
            $this->errorAggregator->addBodyApiError($simpleError);
        }

        $this->throwApiError();
    }

    public function getCaptures(): array
    {
        return $this->captureAggregator->get();
    }

    private function throwApiError(): void
    {
        throw new ApiInvalidBodyException(
            $this->errorAggregator,
            $this->errorAggregator->getErrorStatus()
        );
    }
}
