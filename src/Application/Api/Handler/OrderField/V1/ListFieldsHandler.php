<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler\OrderField\V1;

use Laminas\Diactoros\Response\JsonResponse;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerInterface;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerMethodsTrait;
use Nuvemshop\CustomFields\Application\Api\Query\ParametersMapperInterface;
use Nuvemshop\CustomFields\Application\Api\Validation\Parser\QueryParserInterface;
use Nuvemshop\CustomFields\Domain\Action\OrderField\FieldSearcherAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ListFieldsHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly QueryParserInterface $queryParser,
        private readonly ParametersMapperInterface $parametersMapper,
        private readonly FieldSearcherAction $searcher
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->queryParser->parse(
            null,
            $this->getStoreId($request),
            $request->getQueryParams()
        );

        $this->parametersMapper->applyQueryParameters($this->queryParser, $this->searcher->getRepository());
        $list = $this->searcher->list(true);

        return !$list
            ? new JsonResponse([], 404)
            : new JsonResponse($list, 200, [], JSON_PRETTY_PRINT);
    }
}
