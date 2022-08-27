<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/28
 * Time: 04:35
 */

require_once __DIR__ . '/../vendor/autoload.php';

const CONFIG_PATH = __DIR__ . '/configs';

require_once CONFIG_PATH . '/_path.php';
foreach (require CONFIG_PATH . '/helper.php' as $name) {
    helper($name);
}

foreach (glob(CONFIG_PATH . '/*.php') as $filepath) {
    require_once $filepath;
}
