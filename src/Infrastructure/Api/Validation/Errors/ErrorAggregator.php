<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Errors;

use MessageFormatter;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Response\ApiResponse;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Schema\DocumentInterface;

use function assert;
use function call_user_func;
use function is_object;
use function is_scalar;
use function method_exists;

class ErrorAggregator extends ErrorCollection implements ErrorAggregatorInterface
{
    private array $simpleErrors = [];

    private ?int $errorStatus = null;

    public function getSimpleErrors(): array
    {
        return $this->simpleErrors;
    }

    public function addApiError(string $title, string $detail = null, string $status = null): self
    {
        $this->add(
            new ApiError(
                (string)$status,
                null,
                $title,
                $detail
            )
        );

        return $this;
    }

    public function clear(): ErrorCollection
    {
        $this->simpleErrors = [];
        $this->errorStatus = null;

        return parent::clear();
    }

    public function addQueryParameterApiError(
        SimpleErrorInterface $error,
        int $errorStatus = ApiResponse::HTTP_UNPROCESSABLE_ENTITY
    ): void {
        $title = $this->getErrorMessageTitle();
        $detail = $this->getErrorMessageDetail($error);
        $source = [ApiErrorInterface::SOURCE_PARAMETER => $error->getParameterName()];

        $this->add(
            new ApiError(
                (string)$errorStatus,
                (string)$error->getMessageCode(),
                $title,
                $detail,
                $source
            )
        );
    }

    public function addBodyApiError(
        SimpleErrorInterface $error,
        int $errorStatus = ApiResponse::HTTP_UNPROCESSABLE_ENTITY
    ): void {
        $title = $this->getErrorMessageTitle();
        $detail = $this->getErrorMessageDetail($error);
        $name = $error->getParameterName();
        $pointer = $name
            ? '/' . DocumentInterface::KEYWORD_DATA . '/' . DocumentInterface::KEYWORD_ATTRIBUTES . '/' . $name
            : '/' . DocumentInterface::KEYWORD_DATA;
        $source = [ApiErrorInterface::SOURCE_POINTER => $pointer];

        $this->add(
            new ApiError(
                (string)$errorStatus,
                (string)$error->getMessageCode(),
                $title,
                $detail,
                $source
            )
        );
    }

    public function addErrorStatus(int $status): void
    {
        // Currently (at the moment of writing) the spec is vague about how error status should be set.
        // On the one side it says, for example, 'A server MUST return 409 Conflict when processing a POST
        // request to create a resource with a client-generated ID that already exists.'
        // So you might think 'simple, that should be HTTP status, right?'
        // But on the other
        // - 'it [server] MAY continue processing and encounter multiple problems.'
        // - 'When a server encounters multiple problems for a single request, the most generally applicable
        //    HTTP error code SHOULD be used in the response. For instance, 400 Bad Request might be appropriate
        //    for multiple 4xx errors'

        // So, as we might return multiple errors, we have to figure out what is the best status for response.

        // The strategy is the following: for the first error its error code becomes the Response's status.
        // If any following error code do not match the previous the status becomes generic 400.
        if ($this->errorStatus === null) {
            $this->errorStatus = $status;
        } elseif ($this->errorStatus !== ApiResponse::HTTP_BAD_REQUEST && $this->errorStatus !== $status) {
            $this->errorStatus = ApiResponse::HTTP_BAD_REQUEST;
        }
    }

    public function getErrorStatus(): int
    {
        assert($this->errorStatus !== null, 'Check error code was set');

        return $this->errorStatus;
    }

    private function getErrorMessageTitle(): string
    {
        return ErrorMessages::INVALID_VALUE;
    }

    private function getErrorMessageDetail(SimpleErrorInterface $error): string
    {
        return $this->formatMessage(
            $error->getMessageTemplate(),
            $error->getMessageParameters()
        );
    }

    private function formatMessage(string $message, array $args): string
    {
        // underlying `format` method cannot work with arguments that are not convertible to string
        // therefore we have to check that only those that actually can be used
        assert(
            call_user_func(static function () use ($args): bool {
                $result = true;
                foreach ($args as $arg) {
                    $result = ($result && is_scalar($arg)) ||
                        $arg === null ||
                        (is_object($arg) && method_exists($arg, '__toString'));
                }

                return $result;
            })
        );

        $formatter = MessageFormatter::create('en', $message);
        assert($formatter !== null);

        $formattedMessage = $formatter->format($args);
        assert($formattedMessage, $formatter->getErrorMessage());

        return $formattedMessage;
    }
}
