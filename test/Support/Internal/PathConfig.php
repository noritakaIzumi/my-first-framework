<?php

namespace Support\Internal;

use Internal\Shared\AbstractPathConfig;

class PathConfig extends AbstractPathConfig
{
    protected function _root(): string
    {
        return __DIR__ . '/../../..';
    }

    protected function _app(): string
    {
        return __DIR__ . '/..';
    }

    protected function _config(): string
    {
        return __DIR__ . '/../config';
    }

    protected function _log(): string
    {
        return __DIR__ . '/../_log';
    }
}
