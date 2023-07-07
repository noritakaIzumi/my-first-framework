<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/28
 * Time: 02:56
 */

namespace Internal;

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

        // require composer autoload
        require_once __DIR__ . '/../vendor/autoload.php';

        // load util functions
        foreach (glob(__DIR__ . '/util/*.php') as $file) {
            require_once $file;
        }
    }
}
