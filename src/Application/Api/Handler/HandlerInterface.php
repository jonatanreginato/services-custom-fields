<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface HandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface;
}
