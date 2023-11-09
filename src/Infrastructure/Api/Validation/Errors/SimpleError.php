<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Validation\Errors;

use function is_object;
use function is_scalar;
use function method_exists;

// phpcs:ignoreFile -- this is a readonly class
readonly class SimpleError implements SimpleErrorInterface
{
    public function __construct(
        public ?string $name,
        public mixed $value,
        public int $code,
        public string $messageTemplate,
        public array $messageParameters
    ) {
        assert($this->checkEachValueConvertibleToString($messageParameters));
    }

    public function getParameterName(): ?string
    {
        return $this->name;
    }

    public function getParameterValue(): mixed
    {
        return $this->value;
    }

    public function getMessageCode(): int
    {
        return $this->code;
    }

    public function getMessageTemplate(): string
    {
        return $this->messageTemplate;
    }

    public function getMessageParameters(): array
    {
        return $this->messageParameters;
    }

    private function checkEachValueConvertibleToString(iterable $messageParams): bool
    {
        $result = true;

        foreach ($messageParams as $param) {
            $result = $result && (
                    is_scalar($param) ||
                    $param === null ||
                    (is_object($param) && method_exists($param, '__toString'))
                );
        }

        return true;
    }
}
