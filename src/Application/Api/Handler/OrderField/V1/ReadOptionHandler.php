<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Handler\OrderField\V1;

use Nuvemshop\ApiTemplate\Application\Api\Handler\HandlerInterface;
use Nuvemshop\ApiTemplate\Application\Api\Query\ParametersMapper;
use Nuvemshop\ApiTemplate\Application\Api\Validation\Parser\QueryParser;
use Nuvemshop\ApiTemplate\Domain\Action\Order\OptionSearcherAction;
use Nuvemshop\ApiTemplate\Domain\ValueObject\CustomField\CustomFieldUuid;
use Nuvemshop\ApiTemplate\Domain\ValueObject\IdentifierType;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Encoder\EncoderInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Traits\HandlerMethodsTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ReadOptionHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly QueryParser $queryParser,
        private readonly ParametersMapper $parametersMapper,
        private readonly OptionSearcherAction $searcher,
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
        $data = $this->searcher->readOption(
            new CustomFieldUuid((string)$this->getUuid($request)),
            new IdentifierType((int)$this->getId($request))
        );

        $responses = $this->defaultCreateResponses($request->getUri(), $this->encoder);

        return $data === null
            ? $responses->getCodeResponse(404)
            : $responses->getContentResponse($data, 200);
    }
}
