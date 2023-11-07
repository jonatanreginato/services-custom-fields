<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Web;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ConductCodeHandler extends AbstractHtmlHandler
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse($this->template->render('app::conduct-code'));
    }
}
