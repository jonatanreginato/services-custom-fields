<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler\ThrowableHandler;

use Exception;
use Nuvemshop\CustomFields\Application\Api\Handler\ClassIsTrait;
use Nuvemshop\CustomFields\Application\Api\Response\ApiResponse;
use Nuvemshop\CustomFields\Application\Api\Response\ThrowableResponseInterface;
use Nuvemshop\CustomFields\Application\Api\Validation\Captures\Errors\ApiError;
use Nuvemshop\CustomFields\Application\Api\Validation\Captures\Errors\ApiErrorInterface;
use Nuvemshop\CustomFields\Application\Api\Validation\Captures\Errors\ErrorCollection;
use Nuvemshop\CustomFields\Application\Api\Validation\Captures\Errors\ThrowableConverterInterface;
use Nuvemshop\CustomFields\Application\Api\Validation\Exceptions\ApiException;
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
        $message            = 'Internal Server Error';
        $isJsonApiException = $throwable instanceof ApiException;

        $this->logError($throwable, $message);

        // if exception converter is specified it will be used to convert throwable to ApiException
        if (!$isJsonApiException && $this->throwableConverter !== null) {
            try {
                /** @var ThrowableConverterInterface $converterClass */
                $converterClass = $this->throwableConverter;
                if (($converted = $converterClass::convert($throwable)) !== null) {
                    assert($converted instanceof ApiException);
                    $throwable          = $converted;
                    $isJsonApiException = true;
                }
            } catch (Throwable) {
                //
            }
        }

        // compose JSON API ApiError with appropriate level of details
        if ($isJsonApiException) {
            /** @var ApiException $throwable */
            $errors   = $throwable->getErrors();
            $httpCode = $throwable->getHttpCode();
        } else {
            $errors   = new ErrorCollection();
            $httpCode = $this->httpCodeForUnexpected;
            $details  = null;
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
        $content = $this->encodeErrors($errors);

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

    public function encodeErrors(iterable $errors): string
    {
        $array = $this->encodeErrorsToArray($errors);

        return $this->encodeToJson($array);
    }

    private function encodeErrorsToArray(iterable $errors): array
    {
        $data = [];
        foreach ($errors as $error) {
            assert($error instanceof ApiErrorInterface);
            $representation = array_filter([
                'status' => $error->getStatus(),
                'code'   => $error->getCode(),
                'title'  => $error->getTitle(),
                'detail' => $error->getDetail(),
                'source' => $error->getSource(),
            ]);

            // There is a special case when error representation is an empty array
            // Due to further json transform it must be an object otherwise it will be an empty array in json
            $representation = !empty($representation) ? $representation : (object)$representation;

            $data['errors'][] = $representation;
        }

        return $data;
    }

    private function encodeToJson(array $document): string
    {
        return json_encode($document);
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
