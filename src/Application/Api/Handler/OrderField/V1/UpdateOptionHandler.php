<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Handler\OrderField\V1;

use Nuvemshop\ApiTemplate\Application\Api\Handler\HandlerInterface;
use Nuvemshop\ApiTemplate\Application\Api\Validation\Parser\BodyParserInterface;
use Nuvemshop\ApiTemplate\Domain\Action\Order\OptionUpdaterAction;
use Nuvemshop\ApiTemplate\Domain\ValueObject\CustomField\CustomField;
use Nuvemshop\ApiTemplate\Domain\ValueObject\CustomField\CustomFieldUuid;
use Nuvemshop\ApiTemplate\Domain\ValueObject\IdentifierType;
use Nuvemshop\ApiTemplate\Domain\ValueObject\Option\Option;
use Nuvemshop\ApiTemplate\Domain\ValueObject\Option\OptionValue;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Encoder\EncoderInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Traits\HandlerMethodsTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UpdateOptionHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly BodyParserInterface $bodyParser,
        private readonly OptionUpdaterAction $action,
        private readonly EncoderInterface $encoder
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->bodyParser->parse((string)$request->getBody());
        $captures = $this->bodyParser->getCaptures();

        $option = new Option(
            identifier: new IdentifierType((int)$this->getId($request)),
            optionValue: $this->makeOptionValue($captures['value'] ?? null),
            customField: new CustomField(new CustomFieldUuid((string)$this->getUuid($request)))
        );

        $entity = ($this->action)($option);

        return $this->defaultCreateResponse($entity, $request->getUri(), $this->encoder);
    }

    private function makeOptionValue(?string $value): ?OptionValue
    {
        return !empty($value)
            ? new OptionValue($value)
            : null;
    }
}
