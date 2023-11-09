<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Entity\Category;

use Nuvemshop\CustomFields\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\CustomFields\Domain\Entity\OptionEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\CustomFields\Domain\Repository\CategoryFieldOptionRepository")
 * @ORM\Table(name="metafield_option_categories")
 */
class CategoryFieldOptionEntity extends OptionEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="CategoryFieldEntity", inversedBy="options")
     * @ORM\JoinColumn(name="metafield_uuid", referencedColumnName="uuid")
     */
    public ?CustomFieldEntityInterface $customField = null;
}
