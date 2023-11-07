<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Handler\OrderField\V1;

use Nuvemshop\ApiTemplate\Application\Api\Handler\HandlerInterface;
use Nuvemshop\ApiTemplate\Application\Api\Validation\Parser\BodyParserInterface;
use Nuvemshop\ApiTemplate\Domain\Action\Order\OptionCreatorAction;
use Nuvemshop\ApiTemplate\Domain\ValueObject\Option\Option;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Encoder\EncoderInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Traits\HandlerMethodsTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateOptionHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly BodyParserInterface $bodyParser,
        private readonly OptionCreatorAction $action,
        private readonly EncoderInterface $encoder
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->bodyParser->parse((string)$request->getBody());
        $option = Option::createFromArray(
            array_merge(
                $this->bodyParser->getCaptures(),
                ['uuid' => $this->getUuid($request)],
            )
        );

        $entity = ($this->action)($option);

        return $this->defaultCreateResponse($entity, $request->getUri(), $this->encoder);
    }
}
