<?php

use Cmd\Web;

require_once __DIR__ . '/../../vendor/autoload.php';

require_once __DIR__ . '/../configs/path.php';
foreach (glob(__DIR__ . '/../configs/*.php') as $filepath) {
    require_once $filepath;
}

$web = new Web(__FILE__);
$web->run($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
