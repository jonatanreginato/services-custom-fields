<?php

declare(strict_types=1);

use Nuvemshop\CustomFields\Application\Api\Exceptions\ThrowableConverter;
use Nuvemshop\CustomFields\Domain\Entity\Category\CategoryFieldEntity;
use Nuvemshop\CustomFields\Domain\Entity\Category\CategoryFieldOptionEntity;
use Nuvemshop\CustomFields\Domain\Entity\Category\DateTypeCategoryAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\Category\NumericTypeCategoryAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\Category\OptionTypeCategoryAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\Category\TextTypeCategoryAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\Customer\CustomerFieldEntity;
use Nuvemshop\CustomFields\Domain\Entity\Customer\CustomerFieldOptionEntity;
use Nuvemshop\CustomFields\Domain\Entity\Customer\DateTypeCustomerAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\Customer\NumericTypeCustomerAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\Customer\OptionTypeCustomerAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\Customer\TextTypeCustomerAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\Order\CustomFieldEntity;
use Nuvemshop\CustomFields\Domain\Entity\Order\CustomFieldOptionEntity;
use Nuvemshop\CustomFields\Domain\Entity\Order\DateTypeAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\Order\NumericTypeAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\Order\OptionTypeAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\Order\TextTypeAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\Product\DateTypeProductAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\Product\NumericTypeProductAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\Product\OptionTypeProductAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\Product\ProductFieldEntity;
use Nuvemshop\CustomFields\Domain\Entity\Product\ProductFieldOptionEntity;
use Nuvemshop\CustomFields\Domain\Entity\Product\TextTypeProductAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\ProductVariant\DateTypeProductVariantAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\ProductVariant\NumericTypeProductVariantAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\ProductVariant\OptionTypeProductVariantAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\ProductVariant\ProductVariantFieldEntity;
use Nuvemshop\CustomFields\Domain\Entity\ProductVariant\ProductVariantFieldOptionEntity;
use Nuvemshop\CustomFields\Domain\Entity\ProductVariant\TextTypeProductVariantAssociationEntity;
use Nuvemshop\CustomFields\Domain\Schema\AssociationSchema;
use Nuvemshop\CustomFields\Domain\Schema\CustomFieldSchema;
use Nuvemshop\CustomFields\Domain\Schema\OptionSchema;
use Nuvemshop\CustomFields\Infrastructure\Api\Settings\ApiSettingsInterface;

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
