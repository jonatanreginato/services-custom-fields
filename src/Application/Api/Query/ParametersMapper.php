<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Query;

use Nuvemshop\CustomFields\Application\Api\Validation\Parser\QueryParserInterface;
use Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\Repository;

use function assert;
use function is_string;

class ParametersMapper implements ParametersMapperInterface
{
    private iterable $filters = [];

    private array $attributeFilters = [];

    public function applyQueryParameters(QueryParserInterface $parser, Repository $repository): void
    {
        $this->filters = $parser->getFilters();
        foreach ($this->getMappedFilters() as $filter) {
            /** @var FilterParameter $filter */
            $this->attributeFilters[$filter->field] = $filter->operationsAndArgs;
        }

        $this->appendStoreId($parser->getStoreId());

        $repository->setFilterParameters($this->attributeFilters);
    }

    private function getMappedFilters(): iterable
    {
        foreach ($this->filters as $field => $value) {
            assert(is_string($field));
            $filter = new FilterParameter(
                $field,
                [FilterParameterInterface::OPERATION_EQUALS => [$value]]
            );

            yield $filter;
        }
    }

    private function appendStoreId(int $storeId): void
    {
        $filter = new FilterParameter(
            'storeId',
            [FilterParameterInterface::OPERATION_EQUALS => [$storeId]]
        );

        $this->attributeFilters[$filter->field] = $filter->operationsAndArgs;
    }
}
