<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Action\Order;

use DateTime;
use Nuvemshop\ApiTemplate\Domain\Action\AbstractAction;
use Nuvemshop\ApiTemplate\Domain\Entity\EntityInterface;
use Nuvemshop\ApiTemplate\Domain\ValueObject\AggregateInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Exception\PersistenceException;
use Throwable;

class OptionDeleterAction extends AbstractAction
{
    public function __invoke(AggregateInterface $aggregate): EntityInterface
    {
        try {
            $this->repository->beginTransaction();
            $entity = $this->buildEntity($aggregate);
            $this->repository->remove($entity);
            $this->repository->commit();
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
            $this->repository->rollback();
            throw new PersistenceException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
        }

        return $entity;
    }

    protected function buildEntity(AggregateInterface $aggregate): EntityInterface
    {
        return $this->repository->findOneBy([
            'id'          => $aggregate->getId(),
            'customField' => (string)$aggregate->getCustomFieldUuid(),
        ]);
    }
}
