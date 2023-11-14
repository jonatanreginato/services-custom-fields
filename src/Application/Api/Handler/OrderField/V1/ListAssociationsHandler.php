<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler\OrderField\V1;

use Laminas\Diactoros\Response\JsonResponse;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerInterface;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerMethodsTrait;
use Nuvemshop\CustomFields\Application\Api\Query\ParametersMapper;
use Nuvemshop\CustomFields\Application\Api\Validation\Parser\QueryParser;
use Nuvemshop\CustomFields\Domain\Action\OrderField\AssociationSearcherAction;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomFieldUuid;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ListAssociationsHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly QueryParser $queryParser,
        private readonly ParametersMapper $parametersMapper,
        private readonly AssociationSearcherAction $searcher
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->queryParser->parse(
            $this->getUuid($request),
            $this->getStoreId($request),
            $request->getQueryParams()
        );

        $this->parametersMapper->applyQueryParameters($this->queryParser, $this->searcher->getRepository());
        $list = $this->searcher->listAssociations(new CustomFieldUuid((string)$this->queryParser->getIdentity()));

        return !$list
            ? new JsonResponse([], 404)
            : new JsonResponse($list, 200, [], JSON_PRETTY_PRINT);
    }
}
