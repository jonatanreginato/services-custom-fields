<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Validation\Parser;

use Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Captures\CaptureAggregatorInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Errors\ErrorAggregatorInterface;

interface ParserFactoryInterface
{
    public function createQueryParser(ErrorAggregatorInterface $errorCollection): QueryParserInterface;

    public function createBodyParser(
        CaptureAggregatorInterface $captureAggregator,
        ErrorAggregatorInterface $errorCollection
    ): BodyParserInterface;
}
