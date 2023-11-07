<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Representation;

use function assert;

abstract class BaseWriter implements BaseWriterInterface
{
    protected array $data = [];

    protected string $urlPrefix = '';

    protected bool $isDataAnArray = false;

    public function setUrlPrefix(string $prefix): BaseWriterInterface
    {
        $this->urlPrefix = $prefix;

        return $this;
    }

    public function setDataAsArray(): BaseWriterInterface
    {
        assert(!$this->isDataAnArray);

        $this->data          = [];
        $this->isDataAnArray = true;

        return $this;
    }

    public function getDocument(): array
    {
        return $this->data;
    }
}
