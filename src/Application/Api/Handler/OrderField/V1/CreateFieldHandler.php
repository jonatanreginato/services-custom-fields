<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Handler\OrderField\V1;

use Nuvemshop\ApiTemplate\Application\Api\Handler\HandlerInterface;
use Nuvemshop\ApiTemplate\Application\Api\Validation\Parser\BodyParserInterface;
use Nuvemshop\ApiTemplate\Domain\Action\Order\FieldCreatorAction;
use Nuvemshop\ApiTemplate\Domain\ValueObject\CustomField\CustomField;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Encoder\EncoderInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Traits\HandlerMethodsTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateFieldHandler implements HandlerInterface
{
    use HandlerMethodsTrait;

    public function __construct(
        private readonly BodyParserInterface $bodyParser,
        private readonly FieldCreatorAction $action,
        private readonly EncoderInterface $encoder
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

        $entity = ($this->action)($customField);
//        $this->launchMetafieldCreatedEvent($entity);

        return $this->defaultCreateResponse($entity, $request->getUri(), $this->encoder);
    }
}
