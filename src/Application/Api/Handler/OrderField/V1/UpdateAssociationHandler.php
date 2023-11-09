<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler\OrderField\V1;

use Laminas\Diactoros\Response\JsonResponse;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerInterface;
use Nuvemshop\CustomFields\Application\Api\Validation\Parser\BodyParserInterface;
use Nuvemshop\CustomFields\Domain\Action\Order\AssociationUpdaterAction;
use Nuvemshop\CustomFields\Domain\Schema\AssociationSchema;
use Nuvemshop\CustomFields\Domain\ValueObject\Association\Association;
use Nuvemshop\CustomFields\Domain\ValueObject\Association\AssociationOwner;
use Nuvemshop\CustomFields\Domain\ValueObject\Association\AssociationValue;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomField;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomFieldUuid;
use Nuvemshop\CustomFields\Infrastructure\Api\Http\Traits\HandlerMethodsTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UpdateAssociationHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly BodyParserInterface $bodyParser,
        private readonly AssociationUpdaterAction $action
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->bodyParser->parse((string)$request->getBody());
        $captures = $this->bodyParser->getCaptures();

        $association = new Association(
            associationValue: $this->makeAssociationValue($captures['value'] ?? null),
            associationOwner: new AssociationOwner((int)$this->getId($request)),
            customField: new CustomField(new CustomFieldUuid((string)$this->getUuid($request)))
        );

        $entity = ($this->action)($association, AssociationSchema::class);

        return new JsonResponse($entity, 200, [], JSON_PRETTY_PRINT);
    }

    private function makeAssociationValue(?string $value): ?AssociationValue
    {
        return !empty($value)
            ? new AssociationValue($value)
            : null;
    }
}
