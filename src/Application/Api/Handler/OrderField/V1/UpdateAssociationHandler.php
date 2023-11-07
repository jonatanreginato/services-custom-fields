<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Handler\OrderField\V1;

use Nuvemshop\ApiTemplate\Application\Api\Handler\HandlerInterface;
use Nuvemshop\ApiTemplate\Application\Api\Validation\Parser\BodyParserInterface;
use Nuvemshop\ApiTemplate\Domain\Action\Order\AssociationUpdaterAction;
use Nuvemshop\ApiTemplate\Domain\ValueObject\Association\Association;
use Nuvemshop\ApiTemplate\Domain\ValueObject\Association\AssociationValue;
use Nuvemshop\ApiTemplate\Domain\ValueObject\CustomField\CustomField;
use Nuvemshop\ApiTemplate\Domain\ValueObject\CustomField\CustomFieldUuid;
use Nuvemshop\ApiTemplate\Domain\ValueObject\IdentifierType;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Encoder\EncoderInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Traits\HandlerMethodsTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UpdateAssociationHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly BodyParserInterface $bodyParser,
        private readonly AssociationUpdaterAction $action,
        private readonly EncoderInterface $encoder
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->bodyParser->parse((string)$request->getBody());
        $captures = $this->bodyParser->getCaptures();

        $association = new Association(
            identifier: new IdentifierType((int)$this->getId($request)),
            associationValue: $this->makeAssociationValue($captures['value'] ?? null),
            customField: new CustomField(new CustomFieldUuid((string)$this->getUuid($request)))
        );

        $entity = ($this->action)($association);

        return $this->defaultCreateResponse($entity, $request->getUri(), $this->encoder);
    }

    private function makeAssociationValue(?string $value): ?AssociationValue
    {
        return !empty($value)
            ? new AssociationValue($value)
            : null;
    }
}
