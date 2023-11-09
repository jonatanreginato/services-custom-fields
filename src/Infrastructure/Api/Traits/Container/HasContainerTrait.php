<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Traits\Container;

use Psr\Container\ContainerInterface;

trait HasContainerTrait
{
    private ContainerInterface $container;

    public function setContainer(ContainerInterface $container): self
    {
        $this->container = $container;

        return $this;
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}
