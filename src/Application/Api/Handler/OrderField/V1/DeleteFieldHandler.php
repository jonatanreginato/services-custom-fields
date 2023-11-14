<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler\OrderField\V1;

use Laminas\Diactoros\Response\JsonResponse;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerInterface;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerMethodsTrait;
use Nuvemshop\CustomFields\Domain\Action\OrderField\FieldDeleterAction;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomField;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomFieldStore;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomFieldUuid;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeleteFieldHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly FieldDeleterAction $action
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $customField = new CustomField(
            uuid: new CustomFieldUuid((string)$this->getUuid($request)),
            fieldStore: new CustomFieldStore($this->getStoreId($request))
        );

        ($this->action)($customField);

        return new JsonResponse(null, 204);
    }
}
