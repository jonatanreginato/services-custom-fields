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
            Action\Order\FieldSearcherAction::class                  =>
                static fn(ContainerInterface $container) => new Action\Order\FieldSearcherAction(
                    $container->get(Repository\Order\CustomFieldRepositoryInterface::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\Order\OptionSearcherAction::class                 =>
                static fn(ContainerInterface $container) => new Action\Order\OptionSearcherAction(
                    $container->get(Repository\Order\CustomFieldRepositoryInterface::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\Order\AssociationSearcherAction::class            =>
                static fn(ContainerInterface $container) => new Action\Order\AssociationSearcherAction(
                    $container->get(Repository\Order\CustomFieldRepositoryInterface::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\Order\FieldCreatorAction::class                   =>
                static fn(ContainerInterface $container) => new Action\Order\FieldCreatorAction(
                    $container->get(Repository\Order\CustomFieldRepositoryInterface::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\Order\OptionCreatorAction::class                  =>
                static fn(ContainerInterface $container) => new Action\Order\OptionCreatorAction(
                    $container->get(Repository\Order\CustomFieldRepositoryInterface::class),
                    $container->get(Repository\Order\OptionRepositoryInterface::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\Order\AssociationCreatorAction::class             =>
                static fn(ContainerInterface $container) => new Action\Order\AssociationCreatorAction(
                    $container->get(Repository\Order\CustomFieldRepositoryInterface::class),
                    $container->get(Repository\Order\OptionRepositoryInterface::class),
                    $container->get(Repository\Order\OptionTypeAssociationRepository::class),
                    $container->get(Repository\Order\TextTypeAssociationRepository::class),
                    $container->get(Repository\Order\NumericTypeAssociationRepository::class),
                    $container->get(Repository\Order\DateTypeAssociationRepository::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\Order\FieldUpdaterAction::class                   =>
                static fn(ContainerInterface $container) => new Action\Order\FieldUpdaterAction(
                    $container->get(Repository\Order\CustomFieldRepositoryInterface::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\Order\OptionUpdaterAction::class                  =>
                static fn(ContainerInterface $container) => new Action\Order\OptionUpdaterAction(
                    $container->get(Repository\Order\OptionRepositoryInterface::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\Order\AssociationUpdaterAction::class             =>
                static fn(ContainerInterface $container) => new Action\Order\AssociationUpdaterAction(
                    $container->get(Repository\Order\CustomFieldRepositoryInterface::class),
                    $container->get(Repository\Order\OptionRepositoryInterface::class),
                    $container->get(Repository\Order\OptionTypeAssociationRepository::class),
                    $container->get(Repository\Order\TextTypeAssociationRepository::class),
                    $container->get(Repository\Order\NumericTypeAssociationRepository::class),
                    $container->get(Repository\Order\DateTypeAssociationRepository::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\Order\FieldDeleterAction::class                   =>
                static fn(ContainerInterface $container) => new Action\Order\FieldDeleterAction(
                    $container->get(Repository\Order\CustomFieldRepositoryInterface::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\Order\OptionDeleterAction::class                  =>
                static fn(ContainerInterface $container) => new Action\Order\OptionDeleterAction(
                    $container->get(Repository\Order\OptionRepositoryInterface::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\Order\AssociationDeleterAction::class             =>
                static fn(ContainerInterface $container) => new Action\Order\AssociationDeleterAction(
                    $container->get(Repository\Order\CustomFieldRepositoryInterface::class),
                    $container->get(Repository\Order\OptionTypeAssociationRepository::class),
                    $container->get(Repository\Order\TextTypeAssociationRepository::class),
                    $container->get(Repository\Order\NumericTypeAssociationRepository::class),
                    $container->get(Repository\Order\DateTypeAssociationRepository::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\Order\SearcherAction::class                       =>
                static fn(ContainerInterface $container) => new Action\Order\SearcherAction(
                    $container->get(Repository\Order\OptionTypeAssociationRepository::class),
                    $container->get(Repository\Order\TextTypeAssociationRepository::class),
                    $container->get(Repository\Order\NumericTypeAssociationRepository::class),
                    $container->get(Repository\Order\DateTypeAssociationRepository::class),
                    $container->get(LoggerType::CONSOLE)
                ),
            Action\CounterAction::class                              =>
                static fn(ContainerInterface $container) => new Action\CounterAction(
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
