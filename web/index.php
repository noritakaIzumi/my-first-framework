<?php

use App\UrlParser;

require_once __DIR__ . '/../vendor/autoload.php';

// define constants
const ROOT_PATH = __DIR__;

$urlParser = new UrlParser(__FILE__, $_SERVER['REQUEST_URI']);
$urlComponents = $urlParser->parse();

$path = $urlComponents->getPath();
$query = $urlComponents->getQuery();
$fragment = $urlComponents->getFragment();

return;
