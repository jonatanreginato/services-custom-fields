<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Exceptions;

use LogicException;

class ApiInvalidArgumentException extends LogicException implements ApiExceptionInterface
{
}
