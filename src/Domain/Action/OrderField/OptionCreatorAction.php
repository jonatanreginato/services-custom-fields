<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Action\OrderField;

use DateTime;
use Nuvemshop\CustomFields\Domain\Action\AbstractCreatorAction;
use Nuvemshop\CustomFields\Domain\Entity\EntityInterface;
use Nuvemshop\CustomFields\Domain\Entity\Order\CustomFieldEntity;
use Nuvemshop\CustomFields\Domain\Entity\Order\CustomFieldOptionEntity;
use Nuvemshop\CustomFields\Domain\Exception\DuplicatedOptionValueException;
use Nuvemshop\CustomFields\Domain\Repository\Order\CustomFieldRepositoryInterface;
use Nuvemshop\CustomFields\Domain\Repository\Order\OptionRepository;
use Nuvemshop\CustomFields\Domain\ValueObject\AggregateInterface;
use Nuvemshop\CustomFields\Domain\ValueObject\Option\Option;
use Nuvemshop\CustomFields\Infrastructure\Log\Logger\LoggerFacade;

class OptionCreatorAction extends AbstractCreatorAction
{
    public function __construct(
        protected CustomFieldRepositoryInterface $customFieldRepository,
        OptionRepository $optionRepository,
        LoggerFacade $logger
    ) {
        parent::__construct($optionRepository, $logger);
    }

    public function __invoke(AggregateInterface|Option $aggregate, string $schemaClass): array
    {
        if (
            $this->repository->findOneBy([
                'customField' => (string)$aggregate->getCustomFieldUuid(),
                'value'       => $aggregate->getValue(),
            ])
        ) {
            throw new DuplicatedOptionValueException($aggregate->getValue());
        }

        return parent::__invoke($aggregate, $schemaClass);
    }

    protected function buildEntity(AggregateInterface|Option $aggregate): EntityInterface
    {
        /** @var CustomFieldEntity $customFieldEntity */
        $customFieldEntity = $this->customFieldRepository->getByIdentifier($aggregate->getCustomFieldUuid());

        $entity = new CustomFieldOptionEntity($aggregate, $customFieldEntity);
        $entity->setCreatedAt(new DateTime());
        $entity->setUpdatedAt(new DateTime());

        return $entity;
    }
}
