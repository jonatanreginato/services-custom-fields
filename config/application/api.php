<?php

declare(strict_types=1);

use Nuvemshop\ApiTemplate\Application\Api\Exceptions\ThrowableConverter;
use Nuvemshop\ApiTemplate\Domain\Entity\Category\CategoryFieldEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\Category\CategoryFieldOptionEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\Category\DateTypeCategoryAssociationEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\Category\NumericTypeCategoryAssociationEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\Category\OptionTypeCategoryAssociationEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\Category\TextTypeCategoryAssociationEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\Customer\CustomerFieldEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\Customer\CustomerFieldOptionEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\Customer\DateTypeCustomerAssociationEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\Customer\NumericTypeCustomerAssociationEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\Customer\OptionTypeCustomerAssociationEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\Customer\TextTypeCustomerAssociationEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\Order\CustomFieldEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\Order\CustomFieldOptionEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\Order\DateTypeAssociationEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\Order\NumericTypeAssociationEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\Order\OptionTypeAssociationEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\Order\TextTypeAssociationEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\Product\DateTypeProductAssociationEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\Product\NumericTypeProductAssociationEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\Product\OptionTypeProductAssociationEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\Product\ProductFieldEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\Product\ProductFieldOptionEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\Product\TextTypeProductAssociationEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\ProductVariant\DateTypeProductVariantAssociationEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\ProductVariant\NumericTypeProductVariantAssociationEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\ProductVariant\OptionTypeProductVariantAssociationEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\ProductVariant\ProductVariantFieldEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\ProductVariant\ProductVariantFieldOptionEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\ProductVariant\TextTypeProductVariantAssociationEntity;
use Nuvemshop\ApiTemplate\Domain\Schema\AssociationSchema;
use Nuvemshop\ApiTemplate\Domain\Schema\CustomFieldSchema;
use Nuvemshop\ApiTemplate\Domain\Schema\OptionSchema;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Settings\ApiSettingsInterface;

$jsonOptions = JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT;

return [
    'api' => [
        ApiSettingsInterface::IS_LOG_ENABLED                     => filter_var(getenv('APP_ENABLE_LOGS'), 258),
        ApiSettingsInterface::IS_DEBUG                           => filter_var(getenv('APP_IS_DEBUG'), 258),
        ApiSettingsInterface::DO_NOT_LOG_EXCEPTIONS_LIST         => [],
        ApiSettingsInterface::HTTP_CODE_FOR_UNEXPECTED_THROWABLE => 500,
        ApiSettingsInterface::JSON_API_EXCEPTION_CONVERTER       => ThrowableConverter::class,
        ApiSettingsInterface::JSON_ENCODE_OPTIONS                => $jsonOptions,
        ApiSettingsInterface::JSON_ENCODE_DEPTH                  => 512,
        ApiSettingsInterface::URI_PREFIX                         => '/api/v1',
        ApiSettingsInterface::ENTITY_TO_SCHEMA_MAP               => [
            // Category
            CategoryFieldEntity::class                        => CustomFieldSchema::class,
            CategoryFieldOptionEntity::class                  => OptionSchema::class,
            OptionTypeCategoryAssociationEntity::class        => AssociationSchema::class,
            TextTypeCategoryAssociationEntity::class          => AssociationSchema::class,
            NumericTypeCategoryAssociationEntity::class       => AssociationSchema::class,
            DateTypeCategoryAssociationEntity::class          => AssociationSchema::class,
            // Customer
            CustomerFieldEntity::class                        => CustomFieldSchema::class,
            CustomerFieldOptionEntity::class                  => OptionSchema::class,
            OptionTypeCustomerAssociationEntity::class        => AssociationSchema::class,
            TextTypeCustomerAssociationEntity::class          => AssociationSchema::class,
            NumericTypeCustomerAssociationEntity::class       => AssociationSchema::class,
            DateTypeCustomerAssociationEntity::class          => AssociationSchema::class,
            // Order
            CustomFieldEntity::class                          => CustomFieldSchema::class,
            CustomFieldOptionEntity::class                    => OptionSchema::class,
            OptionTypeAssociationEntity::class                => AssociationSchema::class,
            TextTypeAssociationEntity::class                  => AssociationSchema::class,
            NumericTypeAssociationEntity::class               => AssociationSchema::class,
            DateTypeAssociationEntity::class                  => AssociationSchema::class,
            // Product
            ProductFieldEntity::class                         => CustomFieldSchema::class,
            ProductFieldOptionEntity::class                   => OptionSchema::class,
            OptionTypeProductAssociationEntity::class         => AssociationSchema::class,
            TextTypeProductAssociationEntity::class           => AssociationSchema::class,
            NumericTypeProductAssociationEntity::class        => AssociationSchema::class,
            DateTypeProductAssociationEntity::class           => AssociationSchema::class,
            // ProductVariant
            ProductVariantFieldEntity::class                  => CustomFieldSchema::class,
            ProductVariantFieldOptionEntity::class            => OptionSchema::class,
            OptionTypeProductVariantAssociationEntity::class  => AssociationSchema::class,
            TextTypeProductVariantAssociationEntity::class    => AssociationSchema::class,
            NumericTypeProductVariantAssociationEntity::class => AssociationSchema::class,
            DateTypeProductVariantAssociationEntity::class    => AssociationSchema::class,
        ],
    ]
];
