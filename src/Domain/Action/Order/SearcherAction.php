<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Action\Order;

use Nuvemshop\ApiTemplate\Domain\Repository\Order\DateTypeAssociationRepository;
use Nuvemshop\ApiTemplate\Domain\Repository\Order\NumericTypeAssociationRepository;
use Nuvemshop\ApiTemplate\Domain\Repository\Order\OptionTypeAssociationRepository;
use Nuvemshop\ApiTemplate\Domain\Repository\Order\TextTypeAssociationRepository;
use Nuvemshop\ApiTemplate\Infrastructure\Log\Logger\LoggerFacade;

readonly class SearcherAction
{
    public function __construct(
        protected OptionTypeAssociationRepository $optionTypeOrderAssociationRepository,
        protected TextTypeAssociationRepository $textTypeOrderAssociationRepository,
        protected NumericTypeAssociationRepository $numericTypeOrderAssociationRepository,
        protected DateTypeAssociationRepository $dateTypeOrderAssociationRepository,
        protected LoggerFacade $logger
    ) {
    }

    public function __invoke(int $ownerId): array
    {
        return array_merge(
            $this->optionTypeOrderAssociationRepository->fetchAssociationsByOwner($ownerId),
            $this->textTypeOrderAssociationRepository->fetchAssociationsByOwner($ownerId),
            $this->numericTypeOrderAssociationRepository->fetchAssociationsByOwner($ownerId),
            $this->dateTypeOrderAssociationRepository->fetchAssociationsByOwner($ownerId),
        );
    }
}
