<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Errors;

interface ErrorMessages
{
    public const NAMESPACE_NAME = 'Api.ErrorMessages';

    public const INVALID_VALUE = 'The value is invalid.';
    public const REQUIRED = 'The value is required.';

    public const IS_STRING = 'The value should be a string.';
    public const IS_BOOL = 'The value should be a boolean.';
    public const IS_INT = 'The value should be an integer.';
    public const IS_FLOAT = 'The value should be a float.';
    public const IS_NUMERIC = 'The value should be a numeric.';
    public const IS_DATE_TIME = 'The value should be a valid date time.';
    public const IS_ARRAY = 'The value should be an array.';
    public const IS_UUID = 'The value should be a valid UUID.';

    public const DATE_TIME_BETWEEN = 'The date time value should be between {0} and {1}.';
    public const DATE_TIME_EQUALS = 'The date time value should be equal to {0}.';
    public const DATE_TIME_LESS_OR_EQUALS = 'The date time value should be less or equal to {0}.';
    public const DATE_TIME_LESS_THAN = 'The date time value should be less than {0}.';
    public const DATE_TIME_MORE_OR_EQUALS = 'The date time value should be more or equal to {0}.';
    public const DATE_TIME_MORE_THAN = 'The date time value should be more than {0}.';
    public const DATE_TIME_NOT_EQUALS = 'The date time value should not be equal to {0}.';
    public const NUMERIC_BETWEEN = 'The value should be between {0} and {1}.';
    public const NUMERIC_LESS_OR_EQUALS = 'The value should be less or equal to {0}.';
    public const NUMERIC_LESS_THAN = 'The value should be less than {0}.';
    public const NUMERIC_MORE_OR_EQUALS = 'The value should be more or equal to {0}.';
    public const NUMERIC_MORE_THAN = 'The value should be more than {0}.';
    public const SCALAR_EQUALS = 'The value should be equal to {0}.';
    public const SCALAR_NOT_EQUALS = 'The value should not be equal to {0}.';
    public const SCALAR_IN_VALUES = 'The value is invalid.';
    public const STRING_LENGTH_BETWEEN = 'The value should be between {0} and {1} characters.';
    public const STRING_LENGTH_MIN = 'The value should be at least {0} characters.';
    public const STRING_LENGTH_MAX = 'The value should not be greater than {0} characters.';
    public const STRING_REG_EXP = 'The value format is invalid.';
    public const IS_NULL = 'The value should be NULL.';
    public const IS_NOT_NULL = 'The value should not be NULL.';

    public const INVALID_ATTRIBUTES = 'API attributes are invalid.';
    public const UNKNOWN_ATTRIBUTE = 'Unknown API attribute.';
    public const UNKNOWN_TYPE = 'Unknown API type.';
    public const EXIST_IN_DATABASE_SINGLE = 'The value should be a valid identifier.';
    public const EXIST_IN_DATABASE_MULTIPLE = 'The value should be valid identifiers.';
    public const UNIQUE_IN_DATABASE_SINGLE = 'The value should be a unique identifier.';
    public const INVALID_OPERATION = 'Invalid Operation.';
    public const INVALID_OPERATION_ARGUMENTS = 'Invalid Operation Arguments.';

    public const MSG_ERR_INVALID_ARGUMENT = 'Invalid argument.';
    public const MSG_ERR_INVALID_JSON_DATA_IN_REQUEST = 'Invalid JSON data in request.';
    public const MSG_ERR_CANNOT_CREATE_NON_UNIQUE_RESOURCE = 'Cannot create non unique resource.';
    public const MSG_ERR_CANNOT_UPDATE_WITH_UNIQUE_CONSTRAINT_VIOLATION =
        'Cannot update resource because unique public constraint violated.';
}
