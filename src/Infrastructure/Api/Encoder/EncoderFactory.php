<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Encoder;

use Nuvemshop\ApiTemplate\Infrastructure\Api\Parser\Parser;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Schema\SchemaContainerInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Settings\ApiSettingsInterface;
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
