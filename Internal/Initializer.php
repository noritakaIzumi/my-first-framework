<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/28
 * Time: 02:56
 */

namespace Internal;

use Internal\Shared\Config;
use RuntimeException;

/**
 * Cmd 起動前の初期化処理
 */
class Initializer
{
    public function run(): void
    {
        // required constants
        $constantNames = [
            'APP_PATH',
            'SYSTEM_PATH',
            'LOG_PATH',
        ];
        foreach ($constantNames as $constantName) {
            if (!defined($constantName)) {
                throw new RuntimeException("the config $constantName is not set.");
            }
            $value = constant($constantName);
            if (!is_string($value)) {
                throw new RuntimeException("the config $constantName is not a string.");
            }
            if ($value === '') {
                throw new RuntimeException("the config $constantName is empty.");
            }
        }

        // load util functions
        foreach (glob(__DIR__ . '/util/*.php') as $file) {
            require_once $file;
        }

        // load configs
        shared(Config::class)
            ->phpIni()
            ->errorHandler()
            ->logging()
            ->custom();

        // load routes
        require_once APP_PATH . '/routes.php';
    }
}
