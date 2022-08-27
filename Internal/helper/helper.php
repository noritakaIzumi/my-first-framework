<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/28
 * Time: 02:56
 */

function helper(string $name): void
{
    $override = HELPER_PATH . "/$name.php";
    $base = __DIR__ . "/$name.php";
    if (file_exists($override)) {
        require_once $override;
    }
    if (file_exists($base)) {
        require_once $base;
    }
}
