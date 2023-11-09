<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Parser;

use Nuvemshop\CustomFields\Infrastructure\Api\Validation\Rules\QueryRulesAggregatorInterface;

interface QueryParserInterface extends ParserInterface
{
    public const PARAM_FILTER = 'filter';

    public function setQueryRules(QueryRulesAggregatorInterface $queryRules): void;

    public function parse(?string $identity, int $storeId, array $parameters = []): void;

    public function getIdentity(): ?string;

    public function getStoreId(): int;

    public function getFilters(): iterable;

    public function hasFilters(): bool;
}
