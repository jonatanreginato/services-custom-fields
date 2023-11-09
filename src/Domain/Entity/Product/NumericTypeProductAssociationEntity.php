<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Entity\Product;

use Nuvemshop\CustomFields\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\CustomFields\Domain\Entity\NumericTypeAssociationEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\CustomFields\Domain\Repository\NumericTypeProductAssociationRepository")
 * @ORM\Table(name="metafield_numeric_resource_products")
 */
class NumericTypeProductAssociationEntity extends NumericTypeAssociationEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="ProductFieldEntity", inversedBy="numericAssociations")
     * @ORM\JoinColumn(name="metafield_uuid", referencedColumnName="uuid")
     */
    public ?CustomFieldEntityInterface $customField = null;
}
