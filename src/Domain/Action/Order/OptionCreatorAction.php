<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Action\Order;

use DateTime;
use Nuvemshop\ApiTemplate\Domain\Action\AbstractCreatorAction;
use Nuvemshop\ApiTemplate\Domain\Entity\EntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\Order\CustomFieldEntity;
use Nuvemshop\ApiTemplate\Domain\Entity\Order\CustomFieldOptionEntity;
use Nuvemshop\ApiTemplate\Domain\Exception\DuplicatedOptionValueException;
use Nuvemshop\ApiTemplate\Domain\Repository\Order\CustomFieldRepositoryInterface;
use Nuvemshop\ApiTemplate\Domain\Repository\Order\OptionRepository;
use Nuvemshop\ApiTemplate\Domain\ValueObject\AggregateInterface;
use Nuvemshop\ApiTemplate\Domain\ValueObject\Option\Option;
use Nuvemshop\ApiTemplate\Infrastructure\Log\Logger\LoggerFacade;

class OptionCreatorAction extends AbstractCreatorAction
{
    public function __construct(
        protected CustomFieldRepositoryInterface $customFieldRepository,
        OptionRepository $optionRepository,
        LoggerFacade $logger
    ) {
        parent::__construct($optionRepository, $logger);
    }

    public function __invoke(AggregateInterface|Option $aggregate): EntityInterface
    {
        if (
            $this->repository->findOneBy([
                'customField' => (string)$aggregate->getCustomFieldUuid(),
                'value'       => $aggregate->getValue(),
            ])
        ) {
            throw new DuplicatedOptionValueException($aggregate->getValue());
        }

        return parent::__invoke($aggregate);
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
