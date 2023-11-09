<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\Query\AST\CoalesceExpression;
use Doctrine\ORM\Query\AST\Functions\CurrentDateFunction;
use DoctrineExtensions\Query\Mysql\Date;
use DoctrineExtensions\Query\Mysql\DateDiff;
use DoctrineExtensions\Query\Mysql\Greatest;
use DoctrineExtensions\Query\Mysql\GroupConcat;
use DoctrineExtensions\Query\Mysql\IfElse;
use DoctrineExtensions\Query\Mysql\IfNull;
use DoctrineExtensions\Query\Mysql\Lpad;
use DoctrineExtensions\Query\Mysql\Round;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

class DoctrineConfiguration
{
    public readonly Configuration $config;

    public function __construct(array $doctrineConfig)
    {
        if (!$doctrineConfig) {
            throw new DoctrineException('Missing doctrine config for mysql driver');
        }

        $this->config = new Configuration();
        $this->config->setProxyDir(APP_ROOT . '/cache/proxies');
        $this->config->setProxyNamespace('Nuvemshop\CustomFields\Domain\Entity');
        $this->config->setAutoGenerateProxyClasses(true);
        $this->config->setMetadataDriverImpl(new AttributeDriver($doctrineConfig['entitiesPath'], true));
        $this->config->setNamingStrategy(new UnderscoreNamingStrategy());

        $cacheEnabled = filter_var($doctrineConfig['cache']['enabled'], FILTER_VALIDATE_BOOLEAN);
        if ($cacheEnabled) {
            $cacheDriver = new ArrayAdapter();
            $this->config->setMetadataCache($cacheDriver);
            $this->config->setQueryCache($cacheDriver);
            $this->config->setResultCache($cacheDriver);
        }

        $this->config->setCustomStringFunctions([
            'DATE'         => Date::class,
            'IF'           => IfElse::class,
            'CURDATE'      => CurrentDateFunction::class,
            'DATEDIFF'     => DateDiff::class,
            'GROUP_CONCAT' => GroupConcat::class,
            'ROUND'        => Round::class,
            'GREATEST'     => Greatest::class,
            'IFNULL'       => IfNull::class,
            'COALESCE'     => CoalesceExpression::class,
            'LPAD'         => Lpad::class,
        ]);
    }
}
