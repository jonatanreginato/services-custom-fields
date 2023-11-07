<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Http\ThrowableHandlers;

use Exception;
use Nuvemshop\ApiTemplate\Application\Api\Exceptions\ThrowableConverterInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Encoder\EncoderInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Exceptions\ApiException;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Response\ApiResponse;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Response\ThrowableResponseInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Traits\Reflection\ClassIsTrait;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Errors\ApiError;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Errors\ErrorCollection;
use Psr\Log\LoggerAwareTrait;
use Throwable;

use function assert;
use function get_class;
use function in_array;

class ThrowableHandler implements ThrowableHandlerInterface
{
    use LoggerAwareTrait;
    use ClassIsTrait;

    public function __construct(
        public readonly EncoderInterface $encoder,
        public readonly array $doNotLogClasses,
        public readonly int $httpCodeForUnexpected,
        public readonly bool $isDebug,
        public readonly ?string $throwableConverter
    ) {
        assert(
            $throwableConverter === null ||
            static::classImplements($throwableConverter, ThrowableConverterInterface::class)
        );
    }

    public function createResponse(Throwable $throwable): ThrowableResponseInterface
    {
        $message = 'Internal Server ApiError';
        $isJsonApiException = $throwable instanceof ApiException;

        $this->logError($throwable, $message);

        // if exception converter is specified it will be used to convert throwable to ApiException
        if (!$isJsonApiException && $this->throwableConverter !== null) {
            try {
                /** @var ThrowableConverterInterface $converterClass */
                $converterClass = $this->throwableConverter;
                if (($converted = $converterClass::convert($throwable)) !== null) {
                    assert($converted instanceof ApiException);
                    $throwable = $converted;
                    $isJsonApiException = true;
                }
            } catch (Throwable) {
                //
            }
        }

        // compose JSON API ApiError with appropriate level of details
        if ($isJsonApiException) {
            /** @var ApiException $throwable */
            $errors = $throwable->getErrors();
            $httpCode = $throwable->getHttpCode();
        } else {
            $errors = new ErrorCollection();
            $httpCode = $this->httpCodeForUnexpected;
            $details = null;
            if ($this->isDebug) {
                $message = $throwable->getMessage();
                $details = [$throwable];
            }
            $errors->add(
                new ApiError(
                    null,
                    (string)$httpCode,
                    null,
                    $message,
                    $details
                )
            );
        }

        // encode the error and send to client
        $content = $this->encoder->encodeErrors($errors);

        return $this->createThrowableJsonApiResponse($throwable, $content, $httpCode);
    }

    private function logError(Throwable $throwable, string $message): void
    {
        if ($this->logger !== null && $this->shouldBeLogged($throwable)) {
            // on error (e.g. no permission to write on disk or etc) ignore
            try {
                $this->logger->error($message, ['error' => $throwable]);
            } catch (Exception) {
                //
            }
        }
    }

    private function shouldBeLogged(Throwable $throwable): bool
    {
        return !in_array(get_class($throwable), $this->doNotLogClasses, true);
    }

    private function createThrowableJsonApiResponse(
        Throwable $throwable,
        string $content,
        int $status
    ): ThrowableResponseInterface {
        return new class ($throwable, $content, $status) extends ApiResponse implements ThrowableResponseInterface {
            private Throwable $throwable;

            public function __construct(Throwable $throwable, string $content, int $status)
            {
                parent::__construct($content, $status);
                $this->throwable = $throwable;
            }

            public function getThrowable(): Throwable
            {
                return $this->throwable;
            }
        };
    }
}
