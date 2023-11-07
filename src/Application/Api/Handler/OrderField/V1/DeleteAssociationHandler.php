<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Handler\OrderField\V1;

use Nuvemshop\ApiTemplate\Application\Api\Handler\HandlerInterface;
use Nuvemshop\ApiTemplate\Domain\Action\Order\AssociationDeleterAction;
use Nuvemshop\ApiTemplate\Domain\ValueObject\Association\Association;
use Nuvemshop\ApiTemplate\Domain\ValueObject\CustomField\CustomField;
use Nuvemshop\ApiTemplate\Domain\ValueObject\CustomField\CustomFieldUuid;
use Nuvemshop\ApiTemplate\Domain\ValueObject\IdentifierType;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Encoder\EncoderInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Traits\HandlerMethodsTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeleteAssociationHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly AssociationDeleterAction $action,
        private readonly EncoderInterface $encoder
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $association = new Association(
            identifier: new IdentifierType((int)$this->getId($request)),
            customField: new CustomField(new CustomFieldUuid((string)$this->getUuid($request)))
        );

        ($this->action)($association);

        return $this->defaultCreateResponses($request->getUri(), $this->encoder)->getCodeResponse(204);
    }
}
