<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\RequestId\Exception;

use UnexpectedValueException;

class MissingRequestId extends UnexpectedValueException implements RequestIdExceptionInterface
{
}
