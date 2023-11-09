<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Exceptions;

use Nuvemshop\CustomFields\Infrastructure\Api\Exceptions\ApiException;
use Throwable;

interface ThrowableConverterInterface
{
    public static function convert(Throwable $throwable): ?ApiException;
}
