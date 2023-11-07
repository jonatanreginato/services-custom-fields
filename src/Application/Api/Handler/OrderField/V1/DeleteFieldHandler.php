<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Handler\OrderField\V1;

use Nuvemshop\ApiTemplate\Application\Api\Handler\HandlerInterface;
use Nuvemshop\ApiTemplate\Domain\Action\Order\FieldDeleterAction;
use Nuvemshop\ApiTemplate\Domain\ValueObject\CustomField\CustomField;
use Nuvemshop\ApiTemplate\Domain\ValueObject\CustomField\CustomFieldStore;
use Nuvemshop\ApiTemplate\Domain\ValueObject\CustomField\CustomFieldUuid;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Encoder\EncoderInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Traits\HandlerMethodsTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeleteFieldHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly FieldDeleterAction $action,
        private readonly EncoderInterface $encoder
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $customField = new CustomField(
            uuid: new CustomFieldUuid((string)$this->getUuid($request)),
            fieldStore: new CustomFieldStore($this->getStoreId($request))
        );

        ($this->action)($customField);

        return $this->defaultCreateResponses($request->getUri(), $this->encoder)->getCodeResponse(204);
    }
}
