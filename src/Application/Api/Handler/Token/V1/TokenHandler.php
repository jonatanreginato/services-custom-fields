<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler\Token\V1;

use Laminas\Diactoros\Response\JsonResponse;
use Nuvemshop\CustomFields\Application\Api\Handler\HandlerInterface;
use Nuvemshop\CustomFields\Domain\Exception\JwtException;
use Nuvemshop\CustomFields\Domain\Exception\TokensException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TokenHandler implements HandlerInterface
{
    private const HASH_ALGORITHM = 'sha256';

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $payload = json_decode((string)$request->getBody(), true);
        $secret  = getenv('JWT_SECRET');
        $token   = $this->generateToken($payload, $secret);

        return new JsonResponse($token, 200, [], JSON_PRETTY_PRINT);
    }

    public function generateToken(array $payload, string $secret): string
    {
        foreach ($payload as $key => $value) {
            if (is_int($key)) {
                throw new TokensException('Invalid payload claim.');
            }
        }

        $token =
            $this->encode(['typ' => 'JWT', 'alg' => 'HS256']) . "." .
            $this->encode($payload) . "." .
            $this->signature(
                ['typ' => 'JWT', 'alg' => 'HS256'],
                $payload,
                $secret
            );

        if (!$this->valid($token)) {
            throw new JwtException('Token has an invalid structure.', 1);
        }

        return $token;
    }

    public function encode(array $toEncode): string
    {
        return $this->urlEncode($this->jsonEncode($toEncode));
    }

    public function jsonEncode(array $jsonArray): string
    {
        return (string)json_encode($jsonArray);
    }

    private function urlEncode(string $toEncode): string
    {
        return $this->toBase64Url(base64_encode($toEncode));
    }

    public function toBase64Url(string $base64): string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], $base64);
    }

    public function signature(array $header, array $payload, string $secret): string
    {
        return $this->urlEncode(
            $this->hash(
                $this->getHashAlgorithm(),
                $this->encode($header) . "." . $this->encode($payload),
                $secret
            )
        );
    }

    private function hash(string $algorithm, string $toHash, string $secret): string
    {
        return hash_hmac($algorithm, $toHash, $secret, true);
    }

    private function getHashAlgorithm(): string
    {
        return self::HASH_ALGORITHM;
    }

    private function valid(string $token): bool
    {
        return preg_match('/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/', $token) === 1;
    }
}
