<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler\OrderField\V1;

use Laminas\Diactoros\Response\JsonResponse;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerInterface;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerMethodsTrait;
use Nuvemshop\CustomFields\Application\Api\Validation\Parser\BodyParserInterface;
use Nuvemshop\CustomFields\Domain\Action\OrderField\FieldCreatorAction;
use Nuvemshop\CustomFields\Domain\Schema\CustomFieldSchema;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomField;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateFieldHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly BodyParserInterface $bodyParser,
        private readonly FieldCreatorAction $action
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->bodyParser->parse((string)$request->getBody());
        $customField = CustomField::createFromArray(
            array_merge(
                $this->bodyParser->getCaptures(),
                ['uuid' => $this->getUuid($request)],
                ['store_id' => $this->getStoreId($request)]
            )
        );

        $entity = ($this->action)($customField, CustomFieldSchema::class);
        // $this->launchMetafieldCreatedEvent($entity);

        return new JsonResponse($entity, 201, [], JSON_PRETTY_PRINT);
    }
}
