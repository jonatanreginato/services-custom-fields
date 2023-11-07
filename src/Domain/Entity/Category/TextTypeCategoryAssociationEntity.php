<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\Category;

use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\TextTypeAssociationEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\ApiTemplate\Domain\Repository\TextTypeCategoryAssociationRepository")
 * @ORM\Table(name="metafield_text_resource_categories")
 */
class TextTypeCategoryAssociationEntity extends TextTypeAssociationEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="CategoryFieldEntity", inversedBy="textAssociations")
     * @ORM\JoinColumn(name="metafield_uuid", referencedColumnName="uuid")
     */
    public ?CustomFieldEntityInterface $customField = null;
}
