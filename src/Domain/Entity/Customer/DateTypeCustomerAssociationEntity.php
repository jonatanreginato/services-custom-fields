<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\Customer;

use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\DateTypeAssociationEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\ApiTemplate\Domain\Repository\DateTypeCustomerAssociationRepository")
 * @ORM\Table(name="metafield_date_resource_customers")
 */
class DateTypeCustomerAssociationEntity extends DateTypeAssociationEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="CustomerFieldEntity", inversedBy="dateAssociations")
     * @ORM\JoinColumn(name="metafield_uuid", referencedColumnName="uuid")
     */
    public ?CustomFieldEntityInterface $customField = null;
}
