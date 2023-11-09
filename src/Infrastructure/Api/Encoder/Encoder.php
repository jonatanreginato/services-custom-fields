<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Encoder;

use Nuvemshop\CustomFields\Infrastructure\Api\Exceptions\ApiInvalidArgumentException;
use Nuvemshop\CustomFields\Infrastructure\Api\Parser\ParserInterface;
use Nuvemshop\CustomFields\Infrastructure\Api\Representation\BaseWriterInterface;
use Nuvemshop\CustomFields\Infrastructure\Api\Representation\DocumentWriter;
use Nuvemshop\CustomFields\Infrastructure\Api\Representation\DocumentWriterInterface;
use Nuvemshop\CustomFields\Infrastructure\Api\Representation\ErrorWriter;
use Nuvemshop\CustomFields\Infrastructure\Api\Representation\ErrorWriterInterface;
use Nuvemshop\CustomFields\Infrastructure\Api\Validation\Errors\ApiErrorInterface;
use Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\PaginatedDataInterface;

use function assert;
use function is_array;
use function is_object;
use function json_encode;

class Encoder implements EncoderInterface
{
    use EncoderPropertiesTrait;

    protected const DEFAULT_URL_PREFIX          = '';
    protected const DEFAULT_JSON_ENCODE_OPTIONS = 0;
    protected const DEFAULT_JSON_ENCODE_DEPTH   = 512;

    private ?BaseWriterInterface $writer = null;

    public function __construct(
        private readonly ParserInterface $parser
    ) {
    }

    public function encodeData(iterable|object|null $data): string
    {
        $data  = $this->handlePagingData($data);
        $array = $this->encodeDataToArray($data);

        return $this->encodeToJson($array);
    }

    public function encodeError(ApiErrorInterface $error): string
    {
        $array = $this->encodeErrorToArray($error);

        return $this->encodeToJson($array);
    }

    public function encodeErrors(iterable $errors): string
    {
        $array = $this->encodeErrorsToArray($errors);

        return $this->encodeToJson($array);
    }

    private function handlePagingData(iterable|object|null $resource): iterable|object|null
    {
        if ($resource instanceof PaginatedDataInterface) {
            $resource = $resource->getData();
        }

        return $resource;
    }

    private function encodeDataToArray(iterable|object|null $data): array
    {
        if (!is_array($data) && !is_object($data) && $data !== null) {
            throw new ApiInvalidArgumentException();
        }

        $this->createDocumentWriter();

        assert($this->writer !== null);
        assert($this->writer instanceof DocumentWriterInterface);

        if (is_array($data)) {
            $this->writer->setDataAsArray();
        }
        foreach ($this->parser->parse($data) as $item) {
            $this->writer->addResourceToData($item);
        }

        return $this->writer->getDocument();
    }

    private function createDocumentWriter(): void
    {
        $writer = new DocumentWriter();
        $writer->setUrlPrefix($this->urlPrefix);

        $this->writer = $writer;
    }

    private function encodeErrorToArray(ApiErrorInterface $error): array
    {
        $this->createErrorWriter();

        assert($this->writer !== null);
        assert($this->writer instanceof ErrorWriterInterface);

        $this->writer->addError($error);

        return $this->writer->getDocument();
    }

    private function encodeErrorsToArray(iterable $errors): array
    {
        $this->createErrorWriter();

        assert($this->writer !== null);
        assert($this->writer instanceof ErrorWriterInterface);

        foreach ($errors as $error) {
            assert($error instanceof ApiErrorInterface);
            $this->writer->addError($error);
        }

        return $this->writer->getDocument();
    }

    private function encodeToJson(array $document): string
    {
        return json_encode($document, $this->encodeOptions, $this->encodeDepth);
    }

    private function createErrorWriter(): void
    {
        $writer = new ErrorWriter();
        $writer->setUrlPrefix($this->urlPrefix);

        $this->writer = $writer;
    }
}
