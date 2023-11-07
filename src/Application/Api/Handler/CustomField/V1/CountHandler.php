<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Handler\CustomField\V1;

use Laminas\Diactoros\Response\JsonResponse;
use Nuvemshop\ApiTemplate\Application\Api\Handler\HandlerInterface;
use Nuvemshop\ApiTemplate\Domain\Action\CounterAction;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Traits\HandlerMethodsTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CountHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(private readonly CounterAction $action)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse(
            ($this->action)($this->getStoreId($request)),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }
}
