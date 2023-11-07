<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Jwt;

use Psr\Container\ContainerInterface;
use Throwable;
use Tuupola\Middleware\JwtAuthentication;

class JwtAuthenticationFactory
{
    public function __invoke(ContainerInterface $container): JwtAuthentication
    {
        try {
            $options = $container->get('config')['jwt'] ?? [];
        } catch (Throwable $e) {
            throw new JwtAuthenticationException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        return new JwtAuthentication($options);
    }
}
