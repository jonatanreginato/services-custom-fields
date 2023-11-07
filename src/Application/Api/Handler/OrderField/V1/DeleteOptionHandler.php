<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Handler\OrderField\V1;

use Nuvemshop\ApiTemplate\Application\Api\Handler\HandlerInterface;
use Nuvemshop\ApiTemplate\Domain\Action\Order\OptionDeleterAction;
use Nuvemshop\ApiTemplate\Domain\ValueObject\CustomField\CustomField;
use Nuvemshop\ApiTemplate\Domain\ValueObject\CustomField\CustomFieldUuid;
use Nuvemshop\ApiTemplate\Domain\ValueObject\IdentifierType;
use Nuvemshop\ApiTemplate\Domain\ValueObject\Option\Option;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Encoder\EncoderInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Traits\HandlerMethodsTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeleteOptionHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly OptionDeleterAction $action,
        private readonly EncoderInterface $encoder
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $option = new Option(
            identifier: new IdentifierType((int)$this->getId($request)),
            customField: new CustomField(new CustomFieldUuid((string)$this->getUuid($request)))
        );

        ($this->action)($option);

        return $this->defaultCreateResponses($request->getUri(), $this->encoder)->getCodeResponse(204);
    }
}
