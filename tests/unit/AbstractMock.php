<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields;

use DateTime;
use Monolog\Logger;
use Prophecy\Argument;
use Prophecy\Argument\Token\TypeToken;
use Prophecy\Prophecy\ProphecyInterface;
use Prophecy\Prophet;
use Psr\Http\Message\ResponseInterface as ServerResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractMock
{
    protected Prophet $prophet;

    protected TypeToken|array $typeArray;

    protected TypeToken|bool $typeBoolean;

    protected TypeToken|float $typeFloat;

    protected TypeToken|int $typeInteger;

    protected TypeToken|string $typeString;

    protected TypeToken|DateTime $typeDateTime;

    protected TypeToken|ServerRequestInterface $typeServerRequest;

    protected TypeToken|ServerResponseInterface $typeServerResponse;

    public function __construct(protected Logger $logger)
    {
        $this->prophet = new Prophet();

        $this->typeArray    = Argument::type('array');
        $this->typeBoolean  = Argument::type('bool');
        $this->typeFloat    = Argument::type('float');
        $this->typeInteger  = Argument::type('int');
        $this->typeString   = Argument::type('string');
        $this->typeDateTime = Argument::type(DateTime::class);

        $this->typeServerRequest  = Argument::type(ServerRequestInterface::class);
        $this->typeServerResponse = Argument::type(ServerResponseInterface::class);
    }

    protected function prophesize(string $class): ProphecyInterface
    {
        return $this->prophet->prophesize($class);
    }

    abstract public function getMock(): ProphecyInterface;

    abstract public function getObjectWithMockDependencies(): object;
}
