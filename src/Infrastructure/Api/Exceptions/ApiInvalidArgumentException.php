<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Exceptions;

use LogicException;

class ApiInvalidArgumentException extends LogicException implements ApiExceptionInterface
{
}
