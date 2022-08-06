<?php

const ROOT_PATH = __DIR__;

$parsedUrl = (static function () {
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

$parsedUrl !== false or trigger_error("request uri is invalid: {$_SERVER['REQUEST_URI']}");

$path = $parsedUrl['path'] ?? '';
$query = $parsedUrl['query'] ?? '';
$fragment = $parsedUrl['fragment'] ?? '';

exit;
