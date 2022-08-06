<?php

const ROOT_PATH = __DIR__;

$urlComponents = (static function () {
    $basename = basename(__FILE__);
    $requestUri = preg_replace(
        "#/$basename#",
        '',
        preg_replace(
            '/(\/+)/',
            '/',
            $_SERVER['REQUEST_URI'],
        ),
    );

    return parse_url($requestUri);
})();

is_array($urlComponents) or trigger_error("request uri is invalid: {$_SERVER['REQUEST_URI']}");

$path = $urlComponents['path'] ?? '';
$query = $urlComponents['query'] ?? '';
$fragment = $urlComponents['fragment'] ?? '';

exit;
