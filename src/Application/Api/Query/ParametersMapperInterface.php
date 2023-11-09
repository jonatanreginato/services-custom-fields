<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Query;

use Nuvemshop\CustomFields\Application\Api\Validation\Parser\QueryParserInterface;
use Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\Repository;

interface ParametersMapperInterface
{
    public function applyQueryParameters(QueryParserInterface $parser, Repository $repository): void;
}
