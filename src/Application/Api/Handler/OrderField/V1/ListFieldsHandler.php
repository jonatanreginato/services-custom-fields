<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Handler\OrderField\V1;

use Nuvemshop\ApiTemplate\Application\Api\Handler\HandlerInterface;
use Nuvemshop\ApiTemplate\Application\Api\Query\ParametersMapperInterface;
use Nuvemshop\ApiTemplate\Application\Api\Validation\Parser\QueryParserInterface;
use Nuvemshop\ApiTemplate\Domain\Action\Order\FieldSearcherAction;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Encoder\EncoderInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Traits\HandlerMethodsTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ListFieldsHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly QueryParserInterface $queryParser,
        private readonly ParametersMapperInterface $parametersMapper,
        private readonly FieldSearcherAction $searcher,
        private readonly EncoderInterface $encoder
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
        $list      = $this->searcher->list(true);
        $responses = $this->defaultCreateResponses($request->getUri(), $this->encoder);

        return !$list->getData()
            ? $responses->getCodeResponse(404)
            : $responses->getContentResponse($list, 200);
    }
}
