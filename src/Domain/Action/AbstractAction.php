<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Action;

use Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\Repository;
use Nuvemshop\CustomFields\Infrastructure\Log\Logger\LoggerFacade;

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
