<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\ErrorHandler\Handler;

use Laminas\Stratigility\Middleware\ErrorHandler;
use Psr\Container\ContainerInterface;
use Throwable;

class ErrorHandlerFactory
{
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): ErrorHandler
    {
        if (!$serviceName) {
            throw new ErrorHandlerException('ApiError handler not found');
        }

        /** @var ErrorHandler $errorHandler */
        $errorHandler = $callback();

        foreach ($this->getListeners($container) as $listener) {
            $errorHandler->attachListener($listener);
        }

        return $errorHandler;
    }

    private function getListeners(ContainerInterface $container): array
    {
        try {
            foreach ($container->get('config')['error_handler']['listeners'] as $listenerClass) {
                $listeners[] = $container->get($listenerClass);
            }
        } catch (Throwable $e) {
            throw new ErrorHandlerException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
        }

        return $listeners ?? [];
    }
}
