<?php

use Cmd\WebCmd;

require_once __DIR__ . '/../autoload.php';

$web = new WebCmd(__FILE__);
$web->run($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
