<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Web;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class AbstractHtmlHandlerFactory
{
    public function __invoke(ContainerInterface $container, string $requestedName): AbstractHtmlHandler
    {
//        assert(is_a($requestedName, RequestHandlerInterface::class));

        return new $requestedName(
            $container->get(TemplateRendererInterface::class)
        );
    }
}
