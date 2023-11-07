<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\Product;

use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\OptionEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\OptionTypeAssociationEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\ApiTemplate\Domain\Repository\OptionTypeProductAssociationRepository")
 * @ORM\Table(name="metafield_option_resource_products")
 */
class OptionTypeProductAssociationEntity extends OptionTypeAssociationEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="ProductFieldOptionEntity")
     * @ORM\JoinColumn(name="metafield_value_id", referencedColumnName="id")
     */
    public OptionEntityInterface $value;

    /**
     * @ORM\ManyToOne(targetEntity="ProductFieldEntity", inversedBy="optionAssociations")
     * @ORM\JoinColumn(name="metafield_uuid", referencedColumnName="uuid")
     */
    public ?CustomFieldEntityInterface $customField = null;
}
