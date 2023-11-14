<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Parser;

use Nuvemshop\CustomFields\Application\Api\Validation\Captures\Data\DataAggregatorInterface;
use Nuvemshop\CustomFields\Application\Api\Validation\Captures\Errors\ErrorAggregatorInterface;

interface ParserFactoryInterface
{
    public function createQueryParser(ErrorAggregatorInterface $errorCollection): QueryParserInterface;

    public function createBodyParser(
        DataAggregatorInterface $captureAggregator,
        ErrorAggregatorInterface $errorAggregator
    ): BodyParserInterface;
}
