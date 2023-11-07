<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\ApiTemplate\Domain\Repository\ProductFieldRepository")
 * @ORM\Table(name="metafield_products")
 */
class ProductFieldEntity extends CustomFieldEntity
{
    /**
     * @ORM\OneToMany(targetEntity="ProductFieldOptionEntity", mappedBy="customField")
     */
    public ArrayCollection|PersistentCollection $options;

    /**
     * @ORM\OneToMany(targetEntity="OptionTypeProductAssociationEntity", mappedBy="customField")
     */
    public ArrayCollection|PersistentCollection $optionAssociations;

    /**
     * @ORM\OneToMany(targetEntity="TextTypeProductAssociationEntity", mappedBy="customField")
     */
    public ArrayCollection|PersistentCollection $textAssociations;

    /**
     * @ORM\OneToMany(targetEntity="NumericTypeProductAssociationEntity", mappedBy="customField")
     */
    public ArrayCollection|PersistentCollection $numericAssociations;

    /**
     * @ORM\OneToMany(targetEntity="DateTypeProductAssociationEntity", mappedBy="customField")
     */
    public ArrayCollection|PersistentCollection $dateAssociations;
}
