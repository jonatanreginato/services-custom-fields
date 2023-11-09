<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Exception\Psr\Container;

use DomainException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ContainerException extends DomainException implements NotFoundExceptionInterface
{
    public function __construct(ContainerExceptionInterface $exception)
    {
        parent::__construct(
            $exception->getMessage() ?: 'Container exception.',
            $exception->getCode(),
            $exception->getPrevious()
        );
    }
}
