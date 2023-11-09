<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Entity\Category;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\PersistentCollection;
use Nuvemshop\CustomFields\Domain\Entity\CustomFieldEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\CustomFields\Domain\Repository\CategoryFieldRepository")
 * @ORM\Table(name="metafield_categories")
 */
class CategoryFieldEntity extends CustomFieldEntity
{
    #[OneToMany(mappedBy: 'customField', targetEntity: CategoryFieldOptionEntity::class)]
    public ArrayCollection|PersistentCollection $options;

    #[OneToMany(mappedBy: 'customField', targetEntity: OptionTypeCategoryAssociationEntity::class)]
    public ArrayCollection|PersistentCollection $optionAssociations;

    #[OneToMany(mappedBy: 'customField', targetEntity: TextTypeCategoryAssociationEntity::class)]
    public ArrayCollection|PersistentCollection $textAssociations;

    #[OneToMany(mappedBy: 'customField', targetEntity: NumericTypeCategoryAssociationEntity::class)]
    public ArrayCollection|PersistentCollection $numericAssociations;

    #[OneToMany(mappedBy: 'customField', targetEntity: DateTypeCategoryAssociationEntity::class)]
    public ArrayCollection|PersistentCollection $dateAssociations;
}
