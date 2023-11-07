<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Log\Handler;

use Monolog\Level;
use Monolog\LogRecord;
use Nuvemshop\ApiTemplate\Infrastructure\Log\Exception\InvalidArgumentException as OpenSearchInvalidArgumentException;
use Nuvemshop\ApiTemplate\Infrastructure\Log\Exception\RuntimeException as OpenSearchRuntimeException;
use Nuvemshop\ApiTemplate\Infrastructure\Log\Formatter\OpenSearchFormatter;
use InvalidArgumentException;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Handler\HandlerInterface;
use OpenSearch\Client;
use Throwable;

class OpenSearchHandler extends AbstractProcessingHandler
{
    private const INDEX = '_index';
    private const TYPE  = '_type';
    private const DOC   = '_doc';

    protected array $options = [];

    public function __construct(
        protected Client $client,
        array $options = [],
        int|string|Level $level = Level::Debug,
        bool $bubble = true
    ) {
        parent::__construct($level, $bubble);
        $this->options = array_merge(
            [
                'index'        => 'template',
                'type'         => static::DOC,
                'ignore_error' => false,
            ],
            $options
        );
    }

    protected function write(LogRecord $record): void
    {
        $this->bulkSend([$record['formatted']]);
    }

    public function setFormatter(FormatterInterface $formatter): HandlerInterface
    {
        if ($formatter instanceof OpenSearchFormatter) {
            return parent::setFormatter($formatter);
        }

        throw new InvalidArgumentException('OpenSearchHandler is only compatible with OpenSearchFormatter');
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    protected function getDefaultFormatter(): FormatterInterface
    {
        return new OpenSearchFormatter($this->options['index'], $this->options['type']);
    }

    public function handleBatch(array $records): void
    {
        $documents = $this->getFormatter()->formatBatch($records);
        $this->bulkSend($documents);
    }

    protected function bulkSend(array $records): void
    {
        try {
            $params = [
                'body' => [],
            ];

            foreach ($records as $record) {
                $params['body'][] = [
                    'index' => [
                        static::INDEX => $record[static::INDEX],
                    ],
                ];
                unset($record[static::INDEX], $record[static::TYPE]);

                $params['body'][] = $record;
            }

            $responses = $this->client->bulk($params);

            if ($responses['errors'] === true) {
                throw $this->createExceptionFromResponses($responses);
            }
        } catch (Throwable $e) {
            if (!$this->options['ignore_error']) {
                throw new OpenSearchRuntimeException('ApiError sending messages to OpenSearch', 0, $e);
            }
        }
    }

    protected function createExceptionFromResponses(callable|array $responses): Throwable
    {
        foreach ($responses['items'] ?? [] as $item) {
            if (isset($item['index']['error'])) {
                return $this->createExceptionFromError($item['index']['error']);
            }
        }

        if (class_exists(OpenSearchInvalidArgumentException::class)) {
            return new OpenSearchInvalidArgumentException('OpenSearch failed to index one or more records.');
        }

        return new OpenSearchRuntimeException('OpenSearch failed to index one or more records.');
    }

    protected function createExceptionFromError(array $error): Throwable
    {
        $previous = isset($error['caused_by']) ? $this->createExceptionFromError($error['caused_by']) : null;

        if (class_exists(OpenSearchInvalidArgumentException::class)) {
            return new OpenSearchInvalidArgumentException($error['type'] . ': ' . $error['reason'], 0, $previous);
        }

        return new OpenSearchRuntimeException($error['type'] . ': ' . $error['reason'], 0, $previous);
    }
}
