<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Action\Order;

use Nuvemshop\CustomFields\Domain\Repository\Order\DateTypeAssociationRepository;
use Nuvemshop\CustomFields\Domain\Repository\Order\NumericTypeAssociationRepository;
use Nuvemshop\CustomFields\Domain\Repository\Order\OptionTypeAssociationRepository;
use Nuvemshop\CustomFields\Domain\Repository\Order\TextTypeAssociationRepository;
use Nuvemshop\CustomFields\Infrastructure\Log\Logger\LoggerFacade;

// phpcs:ignoreFile -- this is a readonly class
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
