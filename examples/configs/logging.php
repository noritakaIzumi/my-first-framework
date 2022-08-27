<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/28
 * Time: 04:47
 */

/*
 * ロギング
 */

use Internal\Factory\SharedFactory;
use Internal\Shared\Logging;
use Monolog\Handler\StreamHandler;
use Monolog\Level;

$logging = SharedFactory::getInstance(Logging::class);

$logging->addLogger('default');
$logging
    ->getLogger('default')
    ->pushHandler(new StreamHandler(LOG_PATH . '/default.log', Level::Debug));
