<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Parser;

use Nuvemshop\CustomFields\Infrastructure\Api\Validation\Captures\CaptureAggregator;
use Nuvemshop\CustomFields\Infrastructure\Api\Validation\Captures\CaptureAggregatorInterface;
use Nuvemshop\CustomFields\Infrastructure\Api\Validation\Errors\ErrorAggregator;
use Nuvemshop\CustomFields\Infrastructure\Api\Validation\Errors\ErrorAggregatorInterface;
use Psr\Container\ContainerInterface;

class ParserFactory implements ParserFactoryInterface
{
    public function __invoke(ContainerInterface $container, string $requestedName): ParserInterface
    {
        /** @var ErrorAggregatorInterface $errorCollection */
        $errorCollection = $container->get(ErrorAggregator::class);

        return match ($requestedName) {
            QueryParserInterface::class => $this->createQueryParser($errorCollection),
            BodyParserInterface::class => $this->createBodyParser(
                $container->get(CaptureAggregator::class),
                $errorCollection
            )
        };
    }

    public function createQueryParser(ErrorAggregatorInterface $errorCollection): QueryParserInterface
    {
        return new QueryParser($errorCollection);
    }

    public function createBodyParser(
        CaptureAggregatorInterface $captureAggregator,
        ErrorAggregatorInterface $errorCollection
    ): BodyParserInterface {
        return new BodyParser($captureAggregator, $errorCollection);
    }
}
