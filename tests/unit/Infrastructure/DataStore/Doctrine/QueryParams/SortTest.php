<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\QueryParams;

use Nuvemshop\ApiTemplate\AbstractUnitTestCase;
use Nuvemshop\ApiTemplate\Domain\Entity\UserEntity;
use Nuvemshop\ApiTemplate\UnitTestException;
use ReflectionClass;
use Throwable;

class SortTest extends AbstractUnitTestCase
{
    private static Sort $sort;

    protected function setUp(): void
    {
        try {
            parent::setUp();

            self::$sort = new Sort();

            $reflection = new ReflectionClass(UserEntity::class);
            $properties = $reflection->getProperties();

            foreach ($properties as $property) {
                $propertyName = $property->getName();
                $randomString = random_int(0, 1) ? 'ASC' : 'DESC';
                self::$sort->setParam($propertyName, $randomString);
            }
        } catch (Throwable $e) {
            throw new UnitTestException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
        }
    }

    public function testCanReturnAllOrderData(): void
    {
        $this->logger->info(sprintf(self::DEFAULT_LOG_MESSAGE, __METHOD__, 'none'));

        self::assertNotEmpty(self::$sort->getParam());
        self::assertIsArray(self::$sort->getParam());
    }

    public function testCanThrownErrorOnWrongValue(): void
    {
        $this->logger->info(sprintf(self::DEFAULT_LOG_MESSAGE, __METHOD__, 'none'));

        $this->expectException(QueryParamsException::class);
        (new Sort())->setParam('id', 'CSA');
    }
}
