<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Query;

use Nuvemshop\ApiTemplate\Application\Api\Validation\Parser\QueryParserInterface;
use Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\Repository;

interface ParametersMapperInterface
{
    public function applyQueryParameters(QueryParserInterface $parser, Repository $repository): void;
}
