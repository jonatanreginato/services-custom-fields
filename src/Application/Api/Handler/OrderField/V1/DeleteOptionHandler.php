<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler\OrderField\V1;

use Laminas\Diactoros\Response\JsonResponse;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerInterface;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerMethodsTrait;
use Nuvemshop\CustomFields\Domain\Action\OrderField\OptionDeleterAction;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomField;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomFieldUuid;
use Nuvemshop\CustomFields\Domain\ValueObject\IdentifierType;
use Nuvemshop\CustomFields\Domain\ValueObject\Option\Option;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeleteOptionHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly OptionDeleterAction $action
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $option = new Option(
            identifier: new IdentifierType((int)$this->getId($request)),
            customField: new CustomField(new CustomFieldUuid((string)$this->getUuid($request)))
        );

        ($this->action)($option);

        return new JsonResponse(null, 204);
    }
}
