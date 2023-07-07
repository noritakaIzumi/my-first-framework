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
use RuntimeException;

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

        // required constants
        $constantNames = [
            'APP_PATH',
            'SYSTEM_PATH',
            'CONFIG_PATH',
            'LOG_PATH',
        ];
        foreach ($constantNames as $constantName) {
            if (!defined($constantName)) {
                throw new RuntimeException("the config $constantName is not set.");
            }
        }

        // load util functions
        foreach (glob(__DIR__ . '/util/*.php') as $file) {
            require_once $file;
        }

        // error handler
        set_error_handler('myErrorHandler');

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