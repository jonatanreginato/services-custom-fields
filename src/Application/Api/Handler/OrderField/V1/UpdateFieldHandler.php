<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler\OrderField\V1;

use Laminas\Diactoros\Response\JsonResponse;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerInterface;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerMethodsTrait;
use Nuvemshop\CustomFields\Application\Api\Validation\Parser\BodyParserInterface;
use Nuvemshop\CustomFields\Domain\Action\OrderField\FieldUpdaterAction;
use Nuvemshop\CustomFields\Domain\Schema\CustomFieldSchema;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomField;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomFieldDescription;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomFieldName;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomFieldStore;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomFieldUuid;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UpdateFieldHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly BodyParserInterface $bodyParser,
        private readonly FieldUpdaterAction $action
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

        $entity = ($this->action)($customField, CustomFieldSchema::class);

        return new JsonResponse($entity, 200, [], JSON_PRETTY_PRINT);
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
