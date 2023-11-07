<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Cors;

use Nuvemshop\ApiTemplate\AbstractUnitTestCase;
use Nuvemshop\ApiTemplate\ContainerInterfaceMock;
use Psr\Container\ContainerInterface;
use Throwable;

class CorsMiddlewareFacadeFactoryTest extends AbstractUnitTestCase
{
    public function testCanInvoke(): void
    {
        $this->logger->info(sprintf(self::DEFAULT_LOG_MESSAGE, __METHOD__, 'none'));

        /** @var ContainerInterface $container */
        $container = (new ContainerInterfaceMock($this->logger))->getMock()->reveal();

        $exception = null;
        try {
            (new CorsMiddlewareFactory())($container);
        } catch (Throwable $e) {
            $exception = $e;
        }

        static::assertNull($exception);
    }
}
