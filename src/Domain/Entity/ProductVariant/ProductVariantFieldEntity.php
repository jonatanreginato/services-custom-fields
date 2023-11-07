<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\ProductVariant;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\ApiTemplate\Domain\Repository\ProductVariantFieldRepository")
 * @ORM\Table(name="metafield_product_variants")
 */
class ProductVariantFieldEntity extends CustomFieldEntity
{
    /**
     * @ORM\OneToMany(targetEntity="ProductVariantFieldOptionEntity", mappedBy="customField")
     */
    public ArrayCollection|PersistentCollection $options;

    /**
     * @ORM\OneToMany(targetEntity="OptionTypeProductVariantAssociationEntity", mappedBy="customField")
     */
    public ArrayCollection|PersistentCollection $optionAssociations;

    /**
     * @ORM\OneToMany(targetEntity="TextTypeProductVariantAssociationEntity", mappedBy="customField")
     */
    public ArrayCollection|PersistentCollection $textAssociations;

    /**
     * @ORM\OneToMany(targetEntity="NumericTypeProductVariantAssociationEntity", mappedBy="customField")
     */
    public ArrayCollection|PersistentCollection $numericAssociations;

    /**
     * @ORM\OneToMany(targetEntity="DateTypeProductVariantAssociationEntity", mappedBy="customField")
     */
    public ArrayCollection|PersistentCollection $dateAssociations;
}
