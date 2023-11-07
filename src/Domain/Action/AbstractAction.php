<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Action;

use Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\Repository;
use Nuvemshop\ApiTemplate\Infrastructure\Log\Logger\LoggerFacade;

abstract class AbstractAction
{
    public function __construct(
        protected readonly Repository $repository,
        protected readonly LoggerFacade $logger
    ) {
    }

    public function getRepository(): Repository
    {
        return $this->repository;
    }
}
