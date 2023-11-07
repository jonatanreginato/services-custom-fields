<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Query;

interface FilterParameterInterface
{
    public const OPERATION_EQUALS = 0;
    public const OPERATION_NOT_EQUALS = 1;
    public const OPERATION_LESS_THAN = 2;
    public const OPERATION_LESS_OR_EQUALS = 3;
    public const OPERATION_GREATER_THAN = 4;
    public const OPERATION_GREATER_OR_EQUALS = 5;
    public const OPERATION_LIKE = 6;
    public const OPERATION_NOT_LIKE = 7;
    public const OPERATION_IN = 8;
    public const OPERATION_NOT_IN = 9;
    public const OPERATION_IS_NULL = 10;
    public const OPERATION_IS_NOT_NULL = 11;
}
