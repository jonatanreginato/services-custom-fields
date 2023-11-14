<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManager;
use Nuvemshop\CustomFields\Domain\Action;
use Nuvemshop\CustomFields\Domain\Entity\Order\CustomFieldEntity;
use Nuvemshop\CustomFields\Domain\Entity\Order\CustomFieldOptionEntity;
use Nuvemshop\CustomFields\Domain\Entity\Order\DateTypeAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\Order\NumericTypeAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\Order\OptionTypeAssociationEntity;
use Nuvemshop\CustomFields\Domain\Entity\Order\TextTypeAssociationEntity;
use Nuvemshop\CustomFields\Domain\Repository;
use Nuvemshop\CustomFields\Infrastructure\Log\Logger\LoggerType;
use Psr\Container\ContainerInterface;

return [
    'dependencies' => [
        'factories' => [
            Action\OrderField\FieldSearcherAction::class  =>
                static fn(ContainerInterface $container) => new Action\OrderField\FieldSearcherAction(
                    $container->get(Repository\Order\CustomFieldRepositoryInterface::class),
                    $container->build(
                        $container->get('config')['log']['elasticsearch_logs']['logger'],
                        $container->get('config')['log']['elasticsearch_logs']['options']
                    ),
                ),
            Action\OrderField\OptionSearcherAction::class =>
                static fn(ContainerInterface $container) => new Action\OrderField\OptionSearcherAction(
                    $container->get(Repository\Order\CustomFieldRepositoryInterface::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\OrderField\AssociationSearcherAction::class =>
                static fn(ContainerInterface $container) => new Action\OrderField\AssociationSearcherAction(
                    $container->get(Repository\Order\CustomFieldRepositoryInterface::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\OrderField\FieldCreatorAction::class        =>
                static fn(ContainerInterface $container) => new Action\OrderField\FieldCreatorAction(
                    $container->get(Repository\Order\CustomFieldRepositoryInterface::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\OrderField\OptionCreatorAction::class       =>
                static fn(ContainerInterface $container) => new Action\OrderField\OptionCreatorAction(
                    $container->get(Repository\Order\CustomFieldRepositoryInterface::class),
                    $container->get(Repository\Order\OptionRepositoryInterface::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\OrderField\AssociationCreatorAction::class  =>
                static fn(ContainerInterface $container) => new Action\OrderField\AssociationCreatorAction(
                    $container->get(Repository\Order\CustomFieldRepositoryInterface::class),
                    $container->get(Repository\Order\OptionRepositoryInterface::class),
                    $container->get(Repository\Order\OptionTypeAssociationRepository::class),
                    $container->get(Repository\Order\TextTypeAssociationRepository::class),
                    $container->get(Repository\Order\NumericTypeAssociationRepository::class),
                    $container->get(Repository\Order\DateTypeAssociationRepository::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\OrderField\FieldUpdaterAction::class        =>
                static fn(ContainerInterface $container) => new Action\OrderField\FieldUpdaterAction(
                    $container->get(Repository\Order\CustomFieldRepositoryInterface::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\OrderField\OptionUpdaterAction::class       =>
                static fn(ContainerInterface $container) => new Action\OrderField\OptionUpdaterAction(
                    $container->get(Repository\Order\OptionRepositoryInterface::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\OrderField\AssociationUpdaterAction::class  =>
                static fn(ContainerInterface $container) => new Action\OrderField\AssociationUpdaterAction(
                    $container->get(Repository\Order\CustomFieldRepositoryInterface::class),
                    $container->get(Repository\Order\OptionRepositoryInterface::class),
                    $container->get(Repository\Order\OptionTypeAssociationRepository::class),
                    $container->get(Repository\Order\TextTypeAssociationRepository::class),
                    $container->get(Repository\Order\NumericTypeAssociationRepository::class),
                    $container->get(Repository\Order\DateTypeAssociationRepository::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\OrderField\FieldDeleterAction::class        =>
                static fn(ContainerInterface $container) => new Action\OrderField\FieldDeleterAction(
                    $container->get(Repository\Order\CustomFieldRepositoryInterface::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\OrderField\OptionDeleterAction::class       =>
                static fn(ContainerInterface $container) => new Action\OrderField\OptionDeleterAction(
                    $container->get(Repository\Order\OptionRepositoryInterface::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\OrderField\AssociationDeleterAction::class  =>
                static fn(ContainerInterface $container) => new Action\OrderField\AssociationDeleterAction(
                    $container->get(Repository\Order\CustomFieldRepositoryInterface::class),
                    $container->get(Repository\Order\OptionTypeAssociationRepository::class),
                    $container->get(Repository\Order\TextTypeAssociationRepository::class),
                    $container->get(Repository\Order\NumericTypeAssociationRepository::class),
                    $container->get(Repository\Order\DateTypeAssociationRepository::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\Order\SearcherAction::class            =>
                static fn(ContainerInterface $container) => new Action\Order\SearcherAction(
                    $container->get(Repository\Order\OptionTypeAssociationRepository::class),
                    $container->get(Repository\Order\TextTypeAssociationRepository::class),
                    $container->get(Repository\Order\NumericTypeAssociationRepository::class),
                    $container->get(Repository\Order\DateTypeAssociationRepository::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\CustomFieldsCounterAction::class =>
                static fn(ContainerInterface $container) => new Action\CustomFieldsCounterAction(
                    $container->get(Repository\Order\CustomFieldRepositoryInterface::class),
                ),
            Repository\Order\CustomFieldRepositoryInterface::class   =>
                static fn(ContainerInterface $container) => $container->get(EntityManager::class)->getRepository(
                    CustomFieldEntity::class
                ),
            Repository\Order\OptionRepositoryInterface::class        =>
                static fn(ContainerInterface $container) => $container->get(EntityManager::class)->getRepository(
                    CustomFieldOptionEntity::class
                ),
            Repository\Order\OptionTypeAssociationRepository::class  =>
                static fn(ContainerInterface $container) => $container->get(EntityManager::class)->getRepository(
                    OptionTypeAssociationEntity::class
                ),
            Repository\Order\TextTypeAssociationRepository::class    =>
                static fn(ContainerInterface $container) => $container->get(EntityManager::class)->getRepository(
                    TextTypeAssociationEntity::class
                ),
            Repository\Order\NumericTypeAssociationRepository::class =>
                static fn(ContainerInterface $container) => $container->get(EntityManager::class)->getRepository(
                    NumericTypeAssociationEntity::class
                ),
            Repository\Order\DateTypeAssociationRepository::class    =>
                static fn(ContainerInterface $container) => $container->get(EntityManager::class)->getRepository(
                    DateTypeAssociationEntity::class
                ),
        ],
    ],
];
