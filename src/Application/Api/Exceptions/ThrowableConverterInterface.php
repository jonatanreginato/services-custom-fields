<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Exceptions;

use Nuvemshop\ApiTemplate\Infrastructure\Api\Exceptions\ApiException;
use Throwable;

interface ThrowableConverterInterface
{
    public static function convert(Throwable $throwable): ?ApiException;
}
