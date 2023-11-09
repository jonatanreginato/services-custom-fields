<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\QueryParams;

use Nuvemshop\CustomFields\AbstractUnitTestCase;

class OffsetTest extends AbstractUnitTestCase
{
    public function testCanReturnValue(): void
    {
        $this->logger->info(sprintf(self::DEFAULT_LOG_MESSAGE, __METHOD__, 'none'));

        $limit = new Offset(0);
        self::assertSame(0, $limit->value);

        $limit = new Offset(1);
        self::assertSame(1, $limit->value);

        $limit = new Offset(999);
        self::assertSame(999, $limit->value);
    }

    public function testCanThrownErrorOnNegativeValue(): void
    {
        $this->logger->info(sprintf(self::DEFAULT_LOG_MESSAGE, __METHOD__, 'none'));

        $this->expectException(QueryParamsException::class);
        new Offset(-10);
    }
}
