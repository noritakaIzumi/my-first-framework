<?php

use Command\Web;

require_once __DIR__ . '/../vendor/autoload.php';

$web = new Web(__FILE__);
$web->run($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
