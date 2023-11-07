<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\Category;

use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\DateTypeAssociationEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\ApiTemplate\Domain\Repository\DateTypeCategoryAssociationRepository")
 * @ORM\Table(name="metafield_date_resource_categories")
 */
class DateTypeCategoryAssociationEntity extends DateTypeAssociationEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="CategoryFieldEntity", inversedBy="dateAssociations")
     * @ORM\JoinColumn(name="metafield_uuid", referencedColumnName="uuid")
     */
    public ?CustomFieldEntityInterface $customField = null;
}
