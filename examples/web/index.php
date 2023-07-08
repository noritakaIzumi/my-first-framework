<?php

use Cmd\WebCmd;

require_once __DIR__ . '/../autoload.php';

cmd(WebCmd::class, [$_SERVER['SCRIPT_NAME']])
    ->run($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
