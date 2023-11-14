<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Captures\Errors;

use Nuvemshop\CustomFields\Application\Api\Validation\Exceptions\ApiException;
use Throwable;

interface ThrowableConverterInterface
{
    public static function convert(Throwable $throwable): ?ApiException;
}
