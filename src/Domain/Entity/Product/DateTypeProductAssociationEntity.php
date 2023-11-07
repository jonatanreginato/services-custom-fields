<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\Product;

use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\DateTypeAssociationEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\ApiTemplate\Domain\Repository\DateTypeProductAssociationRepository")
 * @ORM\Table(name="metafield_date_resource_products")
 */
class DateTypeProductAssociationEntity extends DateTypeAssociationEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="ProductFieldEntity", inversedBy="dateAssociations")
     * @ORM\JoinColumn(name="metafield_uuid", referencedColumnName="uuid")
     */
    public ?CustomFieldEntityInterface $customField = null;
}
