<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Swagger;

use Exception;
use Symfony\Component\Yaml\Yaml;

class SwaggerMapper
{
    private array $schemas;

    public readonly Exception $exception;

    public const OUTPUT_PATH = APP_ROOT . '/public/swagger/schemas.yaml';

    public function __construct(private readonly array $mappingPaths)
    {
    }

    public function mapper(): bool
    {
        $result = true;

        $glob = [];
        foreach ($this->mappingPaths as $path) {
            $glob[] = glob($path . '/*.yaml');
        }

        $schemaFiles = array_merge([], ...$glob);

        foreach ($schemaFiles as $file) {
            try {
                $content         = file_get_contents($file);
                $this->schemas[] = $content;
            } catch (Exception $e) {
                $this->exception = $e;
                $result          = false;
            }
        }

        return $result;
    }

    public function toYaml(): bool
    {
        $result = true;
        $data   = [
            'components' => [
                'schemas' => [],
            ],
        ];

        foreach ($this->schemas as $yaml) {
            $schemaData = Yaml::parse($yaml);
            if ($schemaData && $schemaData['components']['schemas']) {
                $data['components']['schemas'] = array_merge(
                    $data['components']['schemas'],
                    $schemaData['components']['schemas']
                );
            }
        }

        try {
            $content = Yaml::dump($data);
            file_put_contents(self::OUTPUT_PATH, $content);
        } catch (Exception $e) {
            $this->exception = $e;
            $result          = false;
        }

        return $result;
    }
}
