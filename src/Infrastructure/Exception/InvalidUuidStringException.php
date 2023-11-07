<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Exception;

use InvalidArgumentException;

class InvalidUuidStringException extends InvalidArgumentException implements UuidExceptionInterface
{
}
