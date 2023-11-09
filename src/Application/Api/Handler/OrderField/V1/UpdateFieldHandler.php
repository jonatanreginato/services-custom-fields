<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler\OrderField\V1;

use Nuvemshop\CustomFields\Application\Api\Handler\HandlerInterface;
use Nuvemshop\CustomFields\Application\Api\Validation\Parser\BodyParserInterface;
use Nuvemshop\CustomFields\Domain\Action\Order\FieldUpdaterAction;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomField;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomFieldDescription;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomFieldName;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomFieldStore;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomFieldUuid;
use Nuvemshop\CustomFields\Infrastructure\Api\Encoder\EncoderInterface;
use Nuvemshop\CustomFields\Infrastructure\Api\Http\Traits\HandlerMethodsTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UpdateFieldHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly BodyParserInterface $bodyParser,
        private readonly FieldUpdaterAction $action,
        private readonly EncoderInterface $encoder
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->bodyParser->parse((string)$request->getBody());
        $captures = $this->bodyParser->getCaptures();

        $customField = new CustomField(
            uuid: new CustomFieldUuid((string)$this->getUuid($request)),
            fieldName: $this->makeName($captures['name'] ?? null),
            fieldDescription: $this->makeDescription($captures['description'] ?? null),
            fieldStore: new CustomFieldStore($this->getStoreId($request))
        );

        $entity = ($this->action)($customField);

        return $this->defaultCreateResponse($entity, $request->getUri(), $this->encoder);
    }

    private function makeName(?string $name): ?CustomFieldName
    {
        return !empty($name)
            ? new CustomFieldName($name)
            : null;
    }

    private function makeDescription(?string $description): ?CustomFieldDescription
    {
        return !empty($description)
            ? new CustomFieldDescription($description)
            : null;
    }
}
