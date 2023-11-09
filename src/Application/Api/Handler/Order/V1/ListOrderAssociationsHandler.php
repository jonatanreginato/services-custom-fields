<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler\Order\V1;

use Laminas\Diactoros\Response\JsonResponse;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerInterface;
use Nuvemshop\CustomFields\Application\Api\Validation\Parser\QueryParser;
use Nuvemshop\CustomFields\Domain\Action\Order\SearcherAction;
use Nuvemshop\CustomFields\Infrastructure\Api\Http\Traits\HandlerMethodsTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ListOrderAssociationsHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly QueryParser $queryParser,
        private readonly SearcherAction $searcher
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->queryParser->parse(
            $this->getId($request),
            $this->getStoreId($request),
            $request->getQueryParams()
        );

        $list = ($this->searcher)((int)$this->getId($request));

        return new JsonResponse($list, 200, [], JSON_PRETTY_PRINT);
    }
}
