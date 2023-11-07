<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\Category;

use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\OptionEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\OptionTypeAssociationEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\ApiTemplate\Domain\Repository\OptionTypeCategoryAssociationRepository")
 * @ORM\Table(name="metafield_option_resource_categories")
 */
class OptionTypeCategoryAssociationEntity extends OptionTypeAssociationEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="CategoryFieldOptionEntity")
     * @ORM\JoinColumn(name="metafield_value_id", referencedColumnName="id")
     */
    public OptionEntityInterface $value;

    /**
     * @ORM\ManyToOne(targetEntity="CategoryFieldEntity", inversedBy="optionAssociations")
     * @ORM\JoinColumn(name="metafield_uuid", referencedColumnName="uuid")
     */
    public ?CustomFieldEntityInterface $customField = null;
}
