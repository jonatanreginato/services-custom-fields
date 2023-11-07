<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\Customer;

use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\NumericTypeAssociationEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\ApiTemplate\Domain\Repository\NumericTypeCustomerAssociationRepository")
 * @ORM\Table(name="metafield_numeric_resource_customers")
 */
class NumericTypeCustomerAssociationEntity extends NumericTypeAssociationEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="CustomerFieldEntity", inversedBy="numericAssociations")
     * @ORM\JoinColumn(name="metafield_uuid", referencedColumnName="uuid")
     */
    public ?CustomFieldEntityInterface $customField = null;
}
