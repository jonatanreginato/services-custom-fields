<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler\Order\V1;

use Laminas\Diactoros\Response\JsonResponse;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerInterface;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerMethodsTrait;
use Nuvemshop\CustomFields\Application\Api\Validation\Parser\QueryParser;
use Nuvemshop\CustomFields\Domain\Action\Order\SearcherAction;
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

        return new JsonResponse(
            $list,
            200,
            [],
            JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        );
    }
}
