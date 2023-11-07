<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\QueryParams;

use Nuvemshop\ApiTemplate\AbstractUnitTestCase;
use Nuvemshop\ApiTemplate\Domain\Entity\UserEntity;
use ReflectionClass;

class FilterTest extends AbstractUnitTestCase
{
    private static Filter $criteria;

    protected function setUp(): void
    {
        parent::setUp();

        self::$criteria = new Filter();

        $reflection = new ReflectionClass(UserEntity::class);
        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $randomString = substr(
                str_shuffle(
                    str_repeat(
                        $string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
                        (int)ceil(10 / strlen($string))
                    )
                ),
                1,
                10
            );
            self::$criteria->setData($propertyName, $randomString);
        }
    }

    public function testCanReturnOneData(): void
    {
        $this->logger->info(sprintf(self::DEFAULT_LOG_MESSAGE, __METHOD__, 'none'));

        self::assertNotEmpty(self::$criteria->getData('id'));
    }

    public function testCanReturnAllData(): void
    {
        $this->logger->info(sprintf(self::DEFAULT_LOG_MESSAGE, __METHOD__, 'none'));

        self::assertNotEmpty(self::$criteria->getData());
        self::assertIsArray(self::$criteria->getData());
    }

    public function testCanUnsetData(): void
    {
        $this->logger->info(sprintf(self::DEFAULT_LOG_MESSAGE, __METHOD__, 'none'));

        self::$criteria->unsetData('id');
        self::assertEmpty(self::$criteria->getData('id'));
    }
}
