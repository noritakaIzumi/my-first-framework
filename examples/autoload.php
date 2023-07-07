<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/28
 * Time: 04:35
 */

use Internal\Initializer;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/path.php';

/*
 * load files
 */
shared(Initializer::class)->run();
