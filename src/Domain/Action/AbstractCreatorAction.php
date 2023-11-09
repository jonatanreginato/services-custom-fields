<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Action;

use Nuvemshop\CustomFields\Domain\Entity\EntityInterface;
use Nuvemshop\CustomFields\Domain\Schema\SchemaInterface;
use Nuvemshop\CustomFields\Domain\ValueObject\AggregateInterface;
use Nuvemshop\CustomFields\Infrastructure\Exception\PersistenceException;
use Throwable;

abstract class AbstractCreatorAction extends AbstractAction
{
    public function __invoke(AggregateInterface $aggregate, string $schemaClass): array
    {
        try {
            $this->repository->beginTransaction();
            $entity = $this->buildEntity($aggregate);
            $this->repository->insert($entity);
            $this->repository->commit();
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
            $this->repository->rollback();
            throw new PersistenceException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
        }

        /** @var $schema SchemaInterface */
        $schema = new $schemaClass($entity);

        return $schema->getAttributes();
    }

    abstract protected function buildEntity(AggregateInterface $aggregate): EntityInterface;
}
