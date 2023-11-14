<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler\CustomField\V1;

use Laminas\Diactoros\Response\JsonResponse;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerInterface;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerMethodsTrait;
use Nuvemshop\CustomFields\Domain\Action\CustomFieldsCounterAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CountHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(private readonly CustomFieldsCounterAction $action)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse(
            ($this->action)($this->getStoreId($request)),
            200,
            [],
            JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        );
    }
}
