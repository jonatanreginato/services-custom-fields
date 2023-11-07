<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\Customer;

use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\OptionEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\ApiTemplate\Domain\Repository\CustomerFieldOptionRepository")
 * @ORM\Table(name="metafield_option_customers")
 */
class CustomerFieldOptionEntity extends OptionEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="CustomerFieldEntity", inversedBy="options")
     * @ORM\JoinColumn(name="metafield_uuid", referencedColumnName="uuid")
     */
    public ?CustomFieldEntityInterface $customField = null;
}
