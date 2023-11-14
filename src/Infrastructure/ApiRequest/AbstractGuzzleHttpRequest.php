<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\ApiRequest;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Throwable;

abstract class AbstractGuzzleHttpRequest implements HttpClientRequest
{
    protected ?string $baseUri = null;

    protected ?string $currentUri = null;

    protected string $currentBody;

    public function __construct(public readonly Client $client)
    {
        $this->currentBody = '';
    }

    public function get(string $uri): HttpClientResponse
    {
        return $this->process('GET', $uri);
    }

    public function post(string $uri, string $body = ''): HttpClientResponse
    {
        return $this->process('POST', $uri, $body);
    }

    public function put(string $uri, string $body = ''): HttpClientResponse
    {
        return $this->process('PUT', $uri, $body);
    }

    public function delete(string $uri, string $body = ''): HttpClientResponse
    {
        return $this->process('DELETE', $uri, $body);
    }

    protected function process(string $method, string $uri, string $body = ''): HttpClientResponse
    {
        $this->currentUri  = $uri;
        $this->currentBody = $body;

        return $this->execute(new Request($method, $uri, $this->client->getConfig('headers'), $body));
    }

    protected function execute(Request $request): HttpClientResponse
    {
        $this->baseUri = $request->getUri()->getPath();
        $response      = '';

        try {
            $response = $this->client->send($request);
        } catch (Throwable $exc) {
            $this->throwException($exc);
        }

        return new HttpClientResponse(
            (string)$response->getBody(),
            $response->getStatusCode()
        );
    }

    protected function throwException(Throwable $exc): void
    {
        if ($exc instanceof RequestException && $exc->hasResponse()) {
            $response = $exc->getResponse()?->getBody()?->getContents();
            $status   = $exc->getResponse()?->getStatusCode() ?? 400;
        }

        throw new HttpClientRequestException(
            $exc->getMessage(),
            $this->baseUri . $this->currentUri,
            (string)($response ?? null),
            $this->currentBody,
            $status ?? 400,
            $exc->getCode()
        );
    }
}
