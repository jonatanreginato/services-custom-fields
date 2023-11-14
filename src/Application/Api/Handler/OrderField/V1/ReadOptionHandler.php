<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler\OrderField\V1;

use Laminas\Diactoros\Response\JsonResponse;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerInterface;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerMethodsTrait;
use Nuvemshop\CustomFields\Application\Api\Query\ParametersMapper;
use Nuvemshop\CustomFields\Application\Api\Validation\Parser\QueryParser;
use Nuvemshop\CustomFields\Domain\Action\OrderField\OptionSearcherAction;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomFieldUuid;
use Nuvemshop\CustomFields\Domain\ValueObject\IdentifierType;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ReadOptionHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly QueryParser $queryParser,
        private readonly ParametersMapper $parametersMapper,
        private readonly OptionSearcherAction $searcher
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
        $data = $this->searcher->readOption(
            new CustomFieldUuid((string)$this->getUuid($request)),
            new IdentifierType((int)$this->getId($request))
        );

        return !$data
            ? new JsonResponse([], 404)
            : new JsonResponse($data, 200, [], JSON_PRETTY_PRINT);
    }
}
