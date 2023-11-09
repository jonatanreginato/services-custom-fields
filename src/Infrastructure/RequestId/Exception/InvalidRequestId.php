<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\RequestId\Exception;

use UnexpectedValueException;

class InvalidRequestId extends UnexpectedValueException implements RequestIdExceptionInterface
{
}
