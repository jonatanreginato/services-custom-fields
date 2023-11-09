<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Exception\Psr\Container;

use DomainException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class NotFoundException extends DomainException implements NotFoundExceptionInterface
{
    public function __construct(ContainerExceptionInterface $exception)
    {
        parent::__construct(
            $exception->getMessage() ?: 'Not Found Exception.',
            $exception->getCode(),
            $exception->getPrevious()
        );
    }
}
