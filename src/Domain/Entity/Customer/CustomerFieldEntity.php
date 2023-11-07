<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\Customer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\ApiTemplate\Domain\Repository\CustomerFieldRepository")
 * @ORM\Table(name="metafield_customers")
 */
class CustomerFieldEntity extends CustomFieldEntity
{
    /**
     * @ORM\OneToMany(targetEntity="CustomerFieldOptionEntity", mappedBy="customField")
     */
    public ArrayCollection|PersistentCollection $options;

    /**
     * @ORM\OneToMany(targetEntity="OptionTypeCustomerAssociationEntity", mappedBy="customField")
     */
    public ArrayCollection|PersistentCollection $optionAssociations;

    /**
     * @ORM\OneToMany(targetEntity="TextTypeCustomerAssociationEntity", mappedBy="customField")
     */
    public ArrayCollection|PersistentCollection $textAssociations;

    /**
     * @ORM\OneToMany(targetEntity="NumericTypeCustomerAssociationEntity", mappedBy="customField")
     */
    public ArrayCollection|PersistentCollection $numericAssociations;

    /**
     * @ORM\OneToMany(targetEntity="DateTypeCustomerAssociationEntity", mappedBy="customField")
     */
    public ArrayCollection|PersistentCollection $dateAssociations;
}
