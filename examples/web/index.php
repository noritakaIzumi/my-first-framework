<?php

use Cmd\WebCmd;

require_once __DIR__ . '/../autoload.php';

$web = cmd(WebCmd::class, [$_SERVER['SCRIPT_NAME']]);
$web->run($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
$web->reset();
