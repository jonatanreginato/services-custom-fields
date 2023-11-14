<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Captures\Errors;

interface ErrorCodes
{
    public const INVALID_VALUE = 1001;
    public const REQUIRED = 1002;

    // Typing - 2xxx
    public const IS_STRING = 2001;
    public const IS_BOOL = 2002;
    public const IS_INT = 2003;
    public const IS_FLOAT = 2004;
    public const IS_NUMERIC = 2005;
    public const IS_DATE_TIME = 2006;
    public const IS_ARRAY = 2007;
    public const IS_UUID = 2008;

    // Comparison - 3xxx
    public const DATE_TIME_BETWEEN = 3001;
    public const DATE_TIME_EQUALS = 3002;
    public const DATE_TIME_LESS_OR_EQUALS = 3003;
    public const DATE_TIME_LESS_THAN = 3004;
    public const DATE_TIME_MORE_OR_EQUALS = 3005;
    public const DATE_TIME_MORE_THAN = 3006;
    public const DATE_TIME_NOT_EQUALS = 3007;
    public const NUMERIC_BETWEEN = 3008;
    public const NUMERIC_LESS_OR_EQUALS = 3009;
    public const NUMERIC_LESS_THAN = 3010;
    public const NUMERIC_MORE_OR_EQUALS = 3011;
    public const NUMERIC_MORE_THAN = 3012;
    public const SCALAR_EQUALS = 3013;
    public const SCALAR_NOT_EQUALS = 3014;
    public const SCALAR_IN_VALUES = 3015;
    public const STRING_LENGTH_BETWEEN = 3016;
    public const STRING_LENGTH_MIN = 3017;
    public const STRING_LENGTH_MAX = 3018;
    public const STRING_REG_EXP = 3019;
    public const IS_NULL = 3020;
    public const IS_NOT_NULL = 3021;

    // API - 4xxx
    public const INVALID_ATTRIBUTES = 4001;
    public const UNKNOWN_ATTRIBUTE = 4002;
    public const UNKNOWN_TYPE = 4003;
    public const EXIST_IN_DATABASE_SINGLE = 4007;
    public const EXIST_IN_DATABASE_MULTIPLE = 4008;
    public const UNIQUE_IN_DATABASE_SINGLE = 4009;
    public const INVALID_OPERATION = 4010;
    public const INVALID_OPERATION_ARGUMENTS = 4011;

    // Special code for those who extend this enum
    public const EXTENDED_ERROR_CODE = 5000;
}
