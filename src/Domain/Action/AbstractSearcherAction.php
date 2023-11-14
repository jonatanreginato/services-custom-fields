<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Action;

use Nuvemshop\CustomFields\Domain\Schema\AssociationSchema;
use Nuvemshop\CustomFields\Domain\Schema\CustomFieldSchema;
use Nuvemshop\CustomFields\Domain\Schema\OptionSchema;

abstract class AbstractSearcherAction extends AbstractAction implements SearcherActionInterface
{
    public function list($withoutDeleted = false): array
    {
        $this->logger->info('teste');

        return CustomFieldSchema::getAttributesFromArray(
            $this->repository->fetchResources($withoutDeleted)
        );
    }

    public function read(mixed $identifier, $withoutDeleted = false): ?array
    {
        $customField = new CustomFieldSchema($this->repository->fetchResource($identifier, $withoutDeleted));

        return $customField->getAttributes();
    }

    public function listOptions(mixed $fieldIdentifier): array
    {
        return OptionSchema::getAttributesFromArray(
            $this->repository->fetchOptions($fieldIdentifier)
        );
    }

    public function readOption(mixed $fieldIdentifier, mixed $optionIdentifier): ?array
    {
        $option = new OptionSchema($this->repository->fetchOption($fieldIdentifier, $optionIdentifier));

        return $option->getAttributes();
    }

    public function listAssociations(mixed $fieldIdentifier): array
    {
        return AssociationSchema::getAttributesFromArray(
            $this->repository->fetchAssociations($fieldIdentifier)
        );
    }

    public function readAssociation(mixed $fieldIdentifier, mixed $ownerIdentifier): ?array
    {
        $association = new AssociationSchema($this->repository->fetchAssociation($fieldIdentifier, $ownerIdentifier));

        return $association->getAttributes();
    }

    public function count(): int
    {
        return $this->repository->countLastQuery();
    }
}
