<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler\OrderField\V1;

use Laminas\Diactoros\Response\JsonResponse;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerInterface;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerMethodsTrait;
use Nuvemshop\CustomFields\Domain\Action\OrderField\AssociationDeleterAction;
use Nuvemshop\CustomFields\Domain\ValueObject\Association\Association;
use Nuvemshop\CustomFields\Domain\ValueObject\Association\AssociationOwner;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomField;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomFieldUuid;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeleteAssociationHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly AssociationDeleterAction $action
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $association = new Association(
            associationOwner: new AssociationOwner((int)$this->getId($request)),
            customField: new CustomField(new CustomFieldUuid((string)$this->getUuid($request)))
        );

        ($this->action)($association);

        return new JsonResponse(null, 204);
    }
}
