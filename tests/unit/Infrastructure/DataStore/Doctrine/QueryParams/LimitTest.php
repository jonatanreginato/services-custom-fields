<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\QueryParams;

use Nuvemshop\CustomFields\AbstractUnitTestCase;

class LimitTest extends AbstractUnitTestCase
{
    public function testCanReturnValue(): void
    {
        $this->logger->info(sprintf(self::DEFAULT_LOG_MESSAGE, __METHOD__, 'none'));

        $limit = new Limit(10);
        self::assertSame(10, $limit->value);
    }

    public function testCanThrownErrorIfValueIsZero(): void
    {
        $this->logger->info(sprintf(self::DEFAULT_LOG_MESSAGE, __METHOD__, 'none'));

        $this->expectException(QueryParamsException::class);
        new Limit(0);
    }

    public function testCanThrownErrorOnNegativeValue(): void
    {
        $this->logger->info(sprintf(self::DEFAULT_LOG_MESSAGE, __METHOD__, 'none'));

        $this->expectException(QueryParamsException::class);
        new Limit(-10);
    }
}
