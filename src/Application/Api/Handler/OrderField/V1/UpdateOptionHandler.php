<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler\OrderField\V1;

use Laminas\Diactoros\Response\JsonResponse;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerInterface;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerMethodsTrait;
use Nuvemshop\CustomFields\Application\Api\Validation\Parser\BodyParserInterface;
use Nuvemshop\CustomFields\Domain\Action\OrderField\OptionUpdaterAction;
use Nuvemshop\CustomFields\Domain\Schema\OptionSchema;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomField;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomFieldUuid;
use Nuvemshop\CustomFields\Domain\ValueObject\IdentifierType;
use Nuvemshop\CustomFields\Domain\ValueObject\Option\Option;
use Nuvemshop\CustomFields\Domain\ValueObject\Option\OptionValue;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UpdateOptionHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly BodyParserInterface $bodyParser,
        private readonly OptionUpdaterAction $action
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

        $entity = ($this->action)($option, OptionSchema::class);

        return new JsonResponse($entity, 200, [], JSON_PRETTY_PRINT);
    }

    private function makeOptionValue(?string $value): ?OptionValue
    {
        return !empty($value)
            ? new OptionValue($value)
            : null;
    }
}
