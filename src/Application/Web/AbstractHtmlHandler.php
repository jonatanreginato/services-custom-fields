<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Web;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class AbstractHtmlHandler implements RequestHandlerInterface
{
    public function __construct(protected TemplateRendererInterface $template)
    {
    }

    abstract public function handle(ServerRequestInterface $request): ResponseInterface;
}
