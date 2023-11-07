<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\Customer;

use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\OptionEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\OptionTypeAssociationEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\ApiTemplate\Domain\Repository\OptionTypeCustomerAssociationRepository")
 * @ORM\Table(name="metafield_option_resource_customers")
 */
class OptionTypeCustomerAssociationEntity extends OptionTypeAssociationEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="CustomerFieldOptionEntity")
     * @ORM\JoinColumn(name="metafield_value_id", referencedColumnName="id")
     */
    public OptionEntityInterface $value;

    /**
     * @ORM\ManyToOne(targetEntity="CustomerFieldEntity", inversedBy="optionAssociations")
     * @ORM\JoinColumn(name="metafield_uuid", referencedColumnName="uuid")
     */
    public ?CustomFieldEntityInterface $customField = null;
}
