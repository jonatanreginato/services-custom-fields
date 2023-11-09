<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Encoder;

use Nuvemshop\CustomFields\Infrastructure\Api\Parser\Parser;
use Nuvemshop\CustomFields\Infrastructure\Api\Schema\SchemaContainerInterface;
use Nuvemshop\CustomFields\Infrastructure\Api\Settings\ApiSettingsInterface;
use Psr\Container\ContainerInterface;

class EncoderFactory
{
    public function __invoke(ContainerInterface $container): EncoderInterface
    {
        $encoder = new Encoder(
            new Parser(
                $container->get(SchemaContainerInterface::class)
            )
        );

        $settings = $container->get('config')['api'];
        $encoder
            ->withUrlPrefix($settings[ApiSettingsInterface::URI_PREFIX])
            ->withEncodeOptions($settings[ApiSettingsInterface::JSON_ENCODE_OPTIONS])
            ->withEncodeDepth($settings[ApiSettingsInterface::JSON_ENCODE_DEPTH]);

        return $encoder;
    }
}
