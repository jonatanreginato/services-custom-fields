<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Parser;

use Nuvemshop\CustomFields\Infrastructure\Api\Validation\Captures\CaptureAggregatorInterface;
use Nuvemshop\CustomFields\Infrastructure\Api\Validation\Errors\ErrorAggregatorInterface;

interface ParserFactoryInterface
{
    public function createQueryParser(ErrorAggregatorInterface $errorCollection): QueryParserInterface;

    public function createBodyParser(
        CaptureAggregatorInterface $captureAggregator,
        ErrorAggregatorInterface $errorCollection
    ): BodyParserInterface;
}
