<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Handler\OrderField\V1;

use Nuvemshop\ApiTemplate\Application\Api\Handler\HandlerInterface;
use Nuvemshop\ApiTemplate\Application\Api\Validation\Parser\BodyParserInterface;
use Nuvemshop\ApiTemplate\Domain\Action\Order\AssociationCreatorAction;
use Nuvemshop\ApiTemplate\Domain\ValueObject\Association\Association;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Encoder\EncoderInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Traits\HandlerMethodsTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateAssociationHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly BodyParserInterface $bodyParser,
        private readonly AssociationCreatorAction $action,
        private readonly EncoderInterface $encoder
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->bodyParser->parse((string)$request->getBody());
        $association = Association::createFromArray(
            array_merge(
                $this->bodyParser->getCaptures(),
                ['uuid' => $this->getUuid($request)],
            )
        );

        $entity = ($this->action)($association);

        return $this->defaultCreateResponse($entity, $request->getUri(), $this->encoder);
    }
}
