<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Action;

use Nuvemshop\ApiTemplate\Domain\Entity\EntityInterface;
use Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\PaginatedDataInterface;

abstract class AbstractSearcherAction extends AbstractAction
{
    public function list($withoutDeleted = false): PaginatedDataInterface
    {
        return $this->repository->fetchResources($withoutDeleted);
    }

    public function read(mixed $identifier, $withoutDeleted = false): ?EntityInterface
    {
        return $this->repository->fetchResource($identifier, $withoutDeleted);
    }

    public function listOptions(mixed $fieldIdentifier): PaginatedDataInterface
    {
        return $this->repository->listOptions($fieldIdentifier);
    }

    public function readOption(mixed $fieldIdentifier, mixed $optionIdentifier): ?EntityInterface
    {
        return $this->repository->getOption($fieldIdentifier, $optionIdentifier);
    }

    public function listAssociations(mixed $fieldIdentifier): PaginatedDataInterface
    {
        return $this->repository->listAssociations($fieldIdentifier);
    }

    public function readAssociation(mixed $fieldIdentifier, mixed $ownerIdentifier): ?EntityInterface
    {
        return $this->repository->getAssociation($fieldIdentifier, $ownerIdentifier);
    }

    public function count(): int
    {
        return $this->repository->countLastQuery();
    }
}
