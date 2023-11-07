<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Representation;

use Nuvemshop\ApiTemplate\Infrastructure\Api\Schema\DocumentInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Errors\ApiErrorInterface;

use function array_filter;

class ErrorWriter extends BaseWriter implements ErrorWriterInterface
{
    public function __construct()
    {
        $this->data[DocumentInterface::KEYWORD_ERRORS] = [];
    }

    public function addError(ApiErrorInterface $error): ErrorWriterInterface
    {
        $representation = array_filter([
            DocumentInterface::KEYWORD_ERRORS_STATUS => $error->getStatus(),
            DocumentInterface::KEYWORD_ERRORS_CODE => $error->getCode(),
            DocumentInterface::KEYWORD_ERRORS_TITLE => $error->getTitle(),
            DocumentInterface::KEYWORD_ERRORS_DETAIL => $error->getDetail(),
            DocumentInterface::KEYWORD_ERRORS_SOURCE => $error->getSource(),
        ]);

        // There is a special case when error representation is an empty array
        // Due to further json transform it must be an object otherwise it will be an empty array in json
        $representation = !empty($representation) ? $representation : (object)$representation;

        $this->data[DocumentInterface::KEYWORD_ERRORS][] = $representation;

        return $this;
    }
}
