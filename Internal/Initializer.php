<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/28
 * Time: 02:56
 */

namespace Internal;

use Internal\Shared\Logging;
use Monolog\Handler\StreamHandler;
use Monolog\Level;

/**
 * Cmd 起動前の初期化処理
 */
class Initializer
{
    public function run(): void
    {
        // overwrite php.ini
        ini_set('display_errors', 0);
        ini_set('error_log', __DIR__ . '/_log/php_error.log');

        // load util functions
        foreach (glob(__DIR__ . '/util/*.php') as $file) {
            require_once $file;
        }

        // setup default logging
        $logging = shared(Logging::class);
        $logging->addLogger('default');
        $logging
            ->getLogger('default')
            ->pushHandler(new StreamHandler(LOG_PATH . '/default.log', Level::Debug));

        // load other configs
        foreach (glob(CONFIG_PATH . '/*.php') as $filepath) {
            require_once $filepath;
        }
    }
}
