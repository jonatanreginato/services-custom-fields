<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\Customer;

use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\TextTypeAssociationEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\ApiTemplate\Domain\Repository\TextTypeCustomerAssociationRepository")
 * @ORM\Table(name="metafield_text_resource_customers")
 */
class TextTypeCustomerAssociationEntity extends TextTypeAssociationEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="CustomerFieldEntity", inversedBy="textAssociations")
     * @ORM\JoinColumn(name="metafield_uuid", referencedColumnName="uuid")
     */
    public ?CustomFieldEntityInterface $customField = null;
}
