<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/28
 * Time: 04:35
 */


use Internal\Initializer;

/*
 * load files
 */
require_once __DIR__ . '/path.php';
shared(Initializer::class)->run();
foreach (glob(CONFIG_PATH . '/*.php') as $filepath) {
    require_once $filepath;
}
