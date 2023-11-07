<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\Category;

use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\OptionEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\ApiTemplate\Domain\Repository\CategoryFieldOptionRepository")
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
