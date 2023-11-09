<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\ApiRequest;

interface HttpClientRequest
{
    public function get(string $uri): HttpClientResponse;

    public function post(string $uri, string $body = ''): HttpClientResponse;

    public function put(string $uri, string $body = ''): HttpClientResponse;

    public function delete(string $uri, string $body = ''): HttpClientResponse;
}
