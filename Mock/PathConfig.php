<?php

namespace Mock;

use Internal\Shared\AbstractPathConfig;

class PathConfig extends AbstractPathConfig
{
    /**
     * @inheritDoc
     */
    protected function _root(): string
    {
        return __DIR__ . '/..';
    }

    /**
     * @inheritDoc
     */
    protected function _app(): string
    {
        return __DIR__ . '/../examples';
    }

    /**
     * @inheritDoc
     */
    protected function _log(): string
    {
        return __DIR__ . '/../examples/_log';
    }
}
