<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler\OrderField\V1;

use Nuvemshop\CustomFields\Application\Api\Handler\HandlerInterface;
use Nuvemshop\CustomFields\Application\Api\Query\ParametersMapperInterface;
use Nuvemshop\CustomFields\Application\Api\Validation\Parser\QueryParserInterface;
use Nuvemshop\CustomFields\Domain\Action\Order\FieldSearcherAction;
use Nuvemshop\CustomFields\Infrastructure\Api\Encoder\EncoderInterface;
use Nuvemshop\CustomFields\Infrastructure\Api\Http\Traits\HandlerMethodsTrait;
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
