<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Log\Exception;

use InvalidArgumentException as InvalidArgument;

class InvalidArgumentException extends InvalidArgument implements OpenSearchException
{
}
