<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Parser;

use Nuvemshop\CustomFields\Application\Api\Validation\Captures\Data\DataAggregator;
use Nuvemshop\CustomFields\Application\Api\Validation\Captures\Data\DataAggregatorInterface;
use Nuvemshop\CustomFields\Application\Api\Validation\Captures\Errors\ErrorAggregator;
use Nuvemshop\CustomFields\Application\Api\Validation\Captures\Errors\ErrorAggregatorInterface;
use Psr\Container\ContainerInterface;

class ParserFactory implements ParserFactoryInterface
{
    public function __invoke(ContainerInterface $container, string $requestedName): ParserInterface
    {
        return match ($requestedName) {
            QueryParserInterface::class => $this->createQueryParser(
                $container->get(ErrorAggregator::class)
            ),
            BodyParserInterface::class => $this->createBodyParser(
                $container->get(DataAggregator::class),
                $container->get(ErrorAggregator::class)
            )
        };
    }

    public function createQueryParser(ErrorAggregatorInterface $errorCollection): QueryParserInterface
    {
        return new QueryParser($errorCollection);
    }

    public function createBodyParser(
        DataAggregatorInterface $captureAggregator,
        ErrorAggregatorInterface $errorAggregator
    ): BodyParserInterface {
        return new BodyParser($captureAggregator, $errorAggregator);
    }
}
