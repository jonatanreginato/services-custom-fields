<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Cors;

use Nuvemshop\ApiTemplate\AbstractUnitTestCase;

class CorsMiddlewareExceptionTest extends AbstractUnitTestCase
{
    public function testCanThrowCorsMiddlewareException(): void
    {
        $this->logger->info(sprintf(self::DEFAULT_LOG_MESSAGE, __METHOD__, 'none'));

        try {
            throw new CorsMiddlewareException();
        } catch (CorsMiddlewareException $e) {
            static::assertEquals('CORS Middleware error.', $e->getMessage());
            static::assertEquals(500, $e->getCode());
            static::assertEquals(null, $e->getPrevious());
        }
    }
}
