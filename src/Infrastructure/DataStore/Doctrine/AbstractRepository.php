<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine;

use Closure;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Nuvemshop\ApiTemplate\Domain\Entity\EntityInterface;
use Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\Traits\FilterTrait;
use Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\Traits\QueryBuilderTrait;

abstract class AbstractRepository extends EntityRepository implements Repository
{
    use QueryBuilderTrait;
    use FilterTrait;

    protected string $alias;

    protected ?iterable $filterParameters = null;

    protected EntityQueryBuilder $queryBuilder;

    public function setFilterParameters(iterable $filterParameters): void
    {
        $this->filterParameters = $filterParameters;
    }

    public function fetchResources(bool $withoutDeleted): PaginatedData
    {
        if (!isset($this->queryBuilder)) {
            $this->makeQueryBuilder($withoutDeleted);
        }

        return new PaginatedData($this->queryBuilder->getQuery()->getResult());
    }

    public function fetchResource(mixed $uuid, bool $withoutDeleted): ?EntityInterface
    {
        if (!isset($this->queryBuilder)) {
            $this->makeQueryBuilder($withoutDeleted);
        }

        $this->queryBuilder->andWhere($this->getAlias() . '.uuid = :uuid');
        $this->queryBuilder->setParameter('uuid', $uuid);

        return $this->queryBuilder->getQuery()->getOneOrNullResult();
    }

    public function countLastQuery(): ?int
    {
        if (!$this->queryBuilder || !($this->queryBuilder instanceof QueryBuilder)) {
            return null;
        }

        return (int)$this->queryBuilder
            ->select(sprintf('COUNT(%s) total', $this->getAlias()))
            ->resetDQLPart('groupBy')
            ->resetDQLPart('orderBy')
            ->setFirstResult(null)
            ->setMaxResults(null)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getCount(): int
    {
        if (!isset($this->queryBuilder)) {
            $this->makeQueryBuilder();
        }

        $this->queryBuilder->select('COUNT(1)')
            ->resetDQLPart('groupBy')
            ->resetDQLPart('orderBy')
            ->setFirstResult(null)
            ->setMaxResults(null);

        return (int)$this->queryBuilder->getQuery()->getSingleScalarResult();
    }

    public function find($id, $lockMode = null, $lockVersion = null): mixed
    {
        if (!isset($this->queryBuilder)) {
            $this->makeQueryBuilder();
        }
        $this->queryBuilder->andWhere($this->getAlias() . '.uuid = :uuid');
        $this->queryBuilder->setParameter('uuid', $id);

        return $this->queryBuilder->getQuery()->getOneOrNullResult();
    }

    public function findAll(): mixed
    {
        if (!isset($this->queryBuilder)) {
            $this->makeQueryBuilder();
        }

        return $this->queryBuilder->getQuery()->getResult();
    }

    abstract protected function getAlias(): string;

    public function transactional(Closure $handler): void
    {
        $this->_em->wrapInTransaction($handler);
    }

    public function insert(mixed $entity): mixed
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity;
    }

    public function update(): void
    {
        $this->getEntityManager()->flush();
    }

    public function remove(mixed $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    public function beginTransaction(): void
    {
        $this->getEntityManager()->beginTransaction();
    }

    public function commit(): void
    {
        $this->getEntityManager()->commit();
    }

    public function rollback(): void
    {
        $this->getEntityManager()->rollback();
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
