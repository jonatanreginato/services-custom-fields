<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\Category;

use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\NumericTypeAssociationEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\ApiTemplate\Domain\Repository\NumericTypeCategoryAssociationRepository")
 * @ORM\Table(name="metafield_numeric_resource_categories")
 */
class NumericTypeCategoryAssociationEntity extends NumericTypeAssociationEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="CategoryFieldEntity", inversedBy="numericAssociations")
     * @ORM\JoinColumn(name="metafield_uuid", referencedColumnName="uuid")
     */
    public ?CustomFieldEntityInterface $customField = null;
}
