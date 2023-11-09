<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Action;

use Nuvemshop\CustomFields\Domain\Entity\EntityInterface;
use Nuvemshop\CustomFields\Domain\ValueObject\AggregateInterface;
use Nuvemshop\CustomFields\Infrastructure\Exception\PersistenceException;
use Throwable;

abstract class AbstractUpdaterAction extends AbstractAction
{
    public function __invoke(AggregateInterface $aggregate): EntityInterface
    {
        try {
            $this->repository->beginTransaction();
            $entity = $this->buildEntity($aggregate);
            $this->repository->update();
            $this->repository->commit();
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
            $this->repository->rollback();
            throw new PersistenceException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
        }

        return $entity;
    }

    abstract protected function buildEntity(AggregateInterface $aggregate): EntityInterface;
}
