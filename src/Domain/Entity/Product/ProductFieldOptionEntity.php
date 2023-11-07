<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\Product;

use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\OptionEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\ApiTemplate\Domain\Repository\ProductFieldOptionRepository")
 * @ORM\Table(name="metafield_option_products")
 */
class ProductFieldOptionEntity extends OptionEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="ProductFieldEntity", inversedBy="options")
     * @ORM\JoinColumn(name="metafield_uuid", referencedColumnName="uuid")
     */
    public ?CustomFieldEntityInterface $customField = null;
}
