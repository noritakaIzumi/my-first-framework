<?php

use Internal\Shared\Logging;
use Monolog\Logger;

if (!function_exists('logger')) {
    /**
     * logger を取得します。
     *
     * @param string $name
     *
     * @return Logger
     */
    function logger(string $name = 'default'): Logger
    {
        return shared(Logging::class)->getLogger($name);
    }
}
