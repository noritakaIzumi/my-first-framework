<?php

use Cmd\WebCmd;
use Internal\Shared\Response\WebResponse;

require_once __DIR__ . '/../config/autoload.php';

cmd(WebCmd::class, [$_SERVER['SCRIPT_NAME'], shared(WebResponse::class)])
    ->run($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
