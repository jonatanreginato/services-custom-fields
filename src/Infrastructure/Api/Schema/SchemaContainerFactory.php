<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Schema;

use Nuvemshop\CustomFields\Infrastructure\Api\Settings\ApiSettingsInterface;
use Psr\Container\ContainerInterface;

class SchemaContainerFactory
{
    public function __invoke(ContainerInterface $container): SchemaContainerInterface
    {
        $settings = $container->get('config')['api'];

        return new SchemaContainer(
            $settings[ApiSettingsInterface::ENTITY_TO_SCHEMA_MAP] ?? []
        );
    }
}
