<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\QueryParams;

use Nuvemshop\CustomFields\AbstractUnitTestCase;

class QueryParamsExceptionTest extends AbstractUnitTestCase
{
    public function testCanThrowCorsMiddlewareException(): void
    {
        $this->logger->info(sprintf(self::DEFAULT_LOG_MESSAGE, __METHOD__, 'none'));

        try {
            throw new QueryParamsException();
        } catch (QueryParamsException $e) {
            static::assertEquals('Query params error.', $e->getMessage());
            static::assertEquals(400, $e->getCode());
            static::assertEquals(null, $e->getPrevious());
        }
    }
}
