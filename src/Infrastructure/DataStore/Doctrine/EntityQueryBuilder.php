<?php

namespace Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Composite;
use Doctrine\ORM\QueryBuilder;
use Nuvemshop\CustomFields\Application\Api\Query\FilterParameterInterface;

class EntityQueryBuilder extends QueryBuilder
{
    public function __construct(
        EntityManagerInterface $em,
        public readonly string $entityName,
        public readonly string $mainAlias
    ) {
        parent::__construct($em);
    }

    public function addFilters(iterable $filters): void
    {
        $addWith = $this->expr()->andX();
        $this->applyFilters($addWith, $this->mainAlias, $filters);
        $addWith->count() <= 0 ?: $this->andWhere($addWith);
    }

    public function applyFilters(Composite $expression, string $alias, iterable $filters): void
    {
        foreach ($filters as $field => $operationsWithArgs) {
            assert(
                is_string($field) && !empty($field),
                "Haven't you forgotten to specify a column name in a relationship that joins `$alias` table?"
            );
            $fullFieldName = $this->getFieldWithAlias($alias, $field);
            foreach ($operationsWithArgs as $operation => $arguments) {
                assert(
                    is_iterable($arguments) || is_array($arguments),
                    "Operation arguments are missing for `$field` column. " .
                    'Use an empty array as an empty argument list.'
                );
                $expression->add($this->createFilterExpression($fullFieldName, $operation, $arguments));
            }
        }
    }

    private function getFieldWithAlias(string $alias, string $field): string
    {
        if (!str_contains($field, '.')) {
            return sprintf('%s.%s', $alias, $field);
        }

        return $field;
    }

    private function createFilterExpression(string $fullColumnName, int $operation, iterable $arguments): string
    {
        switch ($operation) {
            case FilterParameterInterface::OPERATION_EQUALS:
                $parameter = $this->firstValue($arguments);
                $expression = $this->expr()->eq($fullColumnName, $this->expr()->literal($parameter));
                break;
            case FilterParameterInterface::OPERATION_NOT_EQUALS:
                $parameter = $this->firstValue($arguments);
                $expression = $this->expr()->neq($fullColumnName, $this->expr()->literal($parameter));
                break;
            case FilterParameterInterface::OPERATION_LESS_THAN:
                $parameter = $this->firstValue($arguments);
                $expression = $this->expr()->lt($fullColumnName, $this->expr()->literal($parameter));
                break;
            case FilterParameterInterface::OPERATION_LESS_OR_EQUALS:
                $parameter = $this->firstValue($arguments);
                $expression = $this->expr()->lte($fullColumnName, $this->expr()->literal($parameter));
                break;
            case FilterParameterInterface::OPERATION_GREATER_THAN:
                $parameter = $this->firstValue($arguments);
                $expression = $this->expr()->gt($fullColumnName, $this->expr()->literal($parameter));
                break;
            case FilterParameterInterface::OPERATION_GREATER_OR_EQUALS:
                $parameter = $this->firstValue($arguments);
                $expression = $this->expr()->gte($fullColumnName, $this->expr()->literal($parameter));
                break;
            case FilterParameterInterface::OPERATION_LIKE:
                $parameter = $this->firstValue($arguments);
                $expression = $this->expr()->like($fullColumnName, $this->expr()->literal($parameter));
                break;
            case FilterParameterInterface::OPERATION_NOT_LIKE:
                $parameter = $this->firstValue($arguments);
                $expression = $this->expr()->notLike($fullColumnName, $this->expr()->literal($parameter));
                break;
            case FilterParameterInterface::OPERATION_IN:
                $expression = $this->expr()->in($fullColumnName, $arguments);
                break;
            case FilterParameterInterface::OPERATION_NOT_IN:
                $expression = $this->expr()->notIn($fullColumnName, $arguments);
                break;
            case FilterParameterInterface::OPERATION_IS_NULL:
                $expression = $this->expr()->isNull($fullColumnName);
                break;
            case FilterParameterInterface::OPERATION_IS_NOT_NULL:
            default:
                assert($operation === FilterParameterInterface::OPERATION_IS_NOT_NULL);
                $expression = $this->expr()->isNotNull($fullColumnName);
                break;
        }

        return $expression;
    }

    private function firstValue(iterable $arguments): mixed
    {
        foreach ($arguments as $argument) {
            return $argument;
        }

        // arguments are empty
        throw new InvalidArgumentException();
    }
}
