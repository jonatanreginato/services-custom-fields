<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Cors;

use Nuvemshop\CustomFields\AbstractUnitTestCase;
use Nuvemshop\CustomFields\ContainerInterfaceMock;
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
