<?php

use Internal\Factory\SharedFactory;
use Internal\Shared\Logging;
use Monolog\Logger;

/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/28
 * Time: 04:39
 */

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
        return SharedFactory::getInstance(Logging::class)->getLogger($name);
    }
}
