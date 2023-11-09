<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Entity\ProductVariant;

use Nuvemshop\CustomFields\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\CustomFields\Domain\Entity\DateTypeAssociationEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\CustomFields\Domain\Repository\DateTypeProductVariantAssociationRepository")
 * @ORM\Table(name="metafield_date_resource_product_variants")
 */
class DateTypeProductVariantAssociationEntity extends DateTypeAssociationEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="ProductVariantFieldEntity", inversedBy="dateAssociations")
     * @ORM\JoinColumn(name="metafield_uuid", referencedColumnName="uuid")
     */
    public ?CustomFieldEntityInterface $customField = null;
}
