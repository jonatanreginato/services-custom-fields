<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Handler\OrderField\V1;

use Nuvemshop\ApiTemplate\Application\Api\Handler\HandlerInterface;
use Nuvemshop\ApiTemplate\Application\Api\Query\ParametersMapper;
use Nuvemshop\ApiTemplate\Application\Api\Validation\Parser\QueryParser;
use Nuvemshop\ApiTemplate\Domain\Action\Order\AssociationSearcherAction;
use Nuvemshop\ApiTemplate\Domain\ValueObject\CustomField\CustomFieldUuid;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Encoder\EncoderInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Traits\HandlerMethodsTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ListAssociationsHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly QueryParser $queryParser,
        private readonly ParametersMapper $parametersMapper,
        private readonly AssociationSearcherAction $searcher,
        private readonly EncoderInterface $encoder
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
        $list      = $this->searcher->listAssociations(new CustomFieldUuid((string)$this->queryParser->getIdentity()));
        $responses = $this->defaultCreateResponses($request->getUri(), $this->encoder);

        return !$list->getData()
            ? $responses->getCodeResponse(404)
            : $responses->getContentResponse($list, 200);
    }
}
