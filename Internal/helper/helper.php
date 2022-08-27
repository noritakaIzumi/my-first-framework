<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/28
 * Time: 02:56
 */

if (function_exists('helper')) {
    trigger_error('you cannot declare the function "helper".', E_USER_ERROR);
} else {
    function helper(string $name): void
    {
        $requireOnce = (static function (string $file): void {
            if (file_exists($file)) {
                require_once $file;
            }
        });

        if (defined('HELPER_PATH')) {
            $requireOnce(HELPER_PATH . "/$name.php");
        }

        $requireOnce(__DIR__ . "/$name.php");
    }
}
