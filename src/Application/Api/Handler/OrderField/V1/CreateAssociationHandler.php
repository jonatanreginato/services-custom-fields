<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler\OrderField\V1;

use Laminas\Diactoros\Response\JsonResponse;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerInterface;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerMethodsTrait;
use Nuvemshop\CustomFields\Application\Api\Validation\Parser\BodyParserInterface;
use Nuvemshop\CustomFields\Domain\Action\OrderField\AssociationCreatorAction;
use Nuvemshop\CustomFields\Domain\Schema\AssociationSchema;
use Nuvemshop\CustomFields\Domain\ValueObject\Association\Association;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateAssociationHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly BodyParserInterface $bodyParser,
        private readonly AssociationCreatorAction $action
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->bodyParser->parse((string)$request->getBody());
        $association = Association::createFromArray(
            array_merge(
                $this->bodyParser->getCaptures(),
                ['uuid' => $this->getUuid($request)],
            )
        );

        $entity = ($this->action)($association, AssociationSchema::class);

        return new JsonResponse($entity, 201, [], JSON_PRETTY_PRINT);
    }
}
