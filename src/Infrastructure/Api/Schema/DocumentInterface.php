<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Schema;

interface DocumentInterface
{
    public const KEYWORD_ATTRIBUTES = 'attributes';
    public const KEYWORD_DATA = 'data';
    public const KEYWORD_ERRORS = 'errors';
    public const KEYWORD_ERRORS_STATUS = 'status';
    public const KEYWORD_ERRORS_CODE = 'code';
    public const KEYWORD_ERRORS_TITLE = 'title';
    public const KEYWORD_ERRORS_DETAIL = 'detail';
    public const KEYWORD_ERRORS_SOURCE = 'source';
    public const PATH_SEPARATOR = '.';
}
