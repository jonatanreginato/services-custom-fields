<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\ValueObject\CustomField;

use InvalidArgumentException;

// phpcs:ignoreFile -- this is a readonly class
final readonly class CustomFieldKey
{
    private const MAX_LENGTH = 60;

    public mixed $key;

    public function __construct(mixed $key, mixed $name)
    {
        if (!is_null($key)) {
            $this->validadeKey($key);
        }

        if (is_null($key)) {
            $key = $this->generateKey($name);
        }

        $this->key = $key;
    }

    private function validadeKey(mixed $key): void
    {
        if (!is_string($key)) {
            throw new InvalidArgumentException('Format value invalid');
        }

        if (strlen($key) > $this->maxLength()) {
            throw new InvalidArgumentException(sprintf('Name length value not valid, expected max %s', $key));
        }
    }

    private function generateKey(mixed $name): string
    {
        $key = $this->sanitize((string)$name);

        $this->validadeKey($key);

        return $key;
    }

    public function __toString(): string
    {
        return $this->key;
    }

    private function maxLength(): int
    {
        return self::MAX_LENGTH;
    }

    private function sanitize(mixed $name): string
    {
        $key = str_replace("/", "-", (string)$name);
        $key = $this->sanitizeTitleWithDashes($key);
        $key = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $key);
        $key = $this->stringDeepReplace($key);
        $key = str_replace('%', '', $key);


        $this->validadeKey($key);

        return $key;
    }

    private function sanitizeTitleWithDashes(string $title): string
    {
        $title = strip_tags($title, '');
        $title = $this->stripAccents($title);
        $title = strtolower($title);

        $title = preg_replace('/&.+?;/', '', $title);
        $title = str_replace('.', '-', $title);
        $title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
        $title = preg_replace('/\s+/', '-', $title);
        $title = preg_replace('|-+|', '-', $title);

        return trim($title, '-');
    }

    private function stripAccents(string $str): string
    {
        return strtr(
            utf8_decode($str),
            utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'),
            'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY'
        );
    }

    private function stringDeepReplace($subject): array|string
    {
        $search  = ['%0d', '%0a', '%0D', '%0A'];
        $found   = true;
        $subject = (string)$subject;
        while ($found) {
            $found = false;
            foreach ($search as $val) {
                while (str_contains($subject, $val)) {
                    $found = true;
                    $subject = str_replace($val, '', $subject);
                }
            }
        }

        return $subject;
    }
}
