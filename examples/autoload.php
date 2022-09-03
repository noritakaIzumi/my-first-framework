<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/28
 * Time: 04:35
 */

/*
 * overwrite php.ini
 */
ini_set('display_errors', 0);
ini_set('error_log', __DIR__ . '/_log/php_error.log');

/*
 * load files
 */
require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/path.php';
foreach (require CONFIG_PATH . '/helper.php' as $name) {
    helper($name);
}
foreach (glob(CONFIG_PATH . '/*.php') as $filepath) {
    require_once $filepath;
}
