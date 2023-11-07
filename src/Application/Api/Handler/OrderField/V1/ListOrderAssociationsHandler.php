<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Handler\OrderField\V1;

use Nuvemshop\ApiTemplate\Application\Api\Handler\HandlerInterface;
use Nuvemshop\ApiTemplate\Application\Api\Query\ParametersMapper;
use Nuvemshop\ApiTemplate\Application\Api\Validation\Parser\QueryParser;
use Nuvemshop\ApiTemplate\Domain\Action\Order\FieldSearcherAction;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Encoder\EncoderInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Traits\HandlerMethodsTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ListOrderAssociationsHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly QueryParser $queryParser,
        private readonly ParametersMapper $parametersMapper,
        private readonly FieldSearcherAction $searcher,
        private readonly EncoderInterface $encoder
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->queryParser->parse((string)$request->getAttribute('id'), $request->getQueryParams());
        $validatedIndex = (string)$this->queryParser->getIdentity();
        $this->parametersMapper->applyQueryParameters($this->queryParser, $this->searcher, $this->encoder);

        $data = $this->searcher->readRole($validatedIndex);

        $responses = $this->defaultCreateResponses($request->getUri(), $this->encoder);

        return $data === null
            ? $responses->getCodeResponse(404)
            : $responses->getContentResponse($data, 200);
    }
}
