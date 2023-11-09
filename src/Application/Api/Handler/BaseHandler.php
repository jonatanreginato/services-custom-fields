<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler;

use Nuvemshop\CustomFields\Infrastructure\Api\Http\ThrowableHandlers\ThrowableHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

use function extension_loaded;
use function get_class;

readonly class BaseHandler implements RequestHandlerInterface
{
    public function __construct(
        private HandlerInterface $strategy,
        protected ThrowableHandlerInterface $throwableHandler,
        protected bool $ignoreNewRelic = false
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $this->configNewRelic(
                get_class($this->strategy),
                json_encode($request->getUri()->getPath(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES)
            );
            return $this->strategy->handle($request);
        } catch (Throwable $exception) {
            return $this->throwableHandler->createResponse($exception);
        } finally {
            self::endOfTransactionNewRelic();
        }
    }

    private function configNewRelic(string $source, string $parameters): void
    {
        if (!extension_loaded('newrelic')) {
            return;
        }

        if ($this->ignoreNewRelic) {
            self::ignoreNewRelic();
            return;
        }

        newrelic_name_transaction($source);
        newrelic_add_custom_parameter('payload', $parameters);
    }

    public static function ignoreNewRelic(): void
    {
        if (extension_loaded('newrelic')) {
            newrelic_ignore_transaction();
        }
    }

    public static function endOfTransactionNewRelic(): void
    {
        if (extension_loaded('newrelic')) {
            newrelic_end_of_transaction();
        }
    }
}
