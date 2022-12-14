<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/06
 * Time: 11:01
 */

namespace Internal\Shared;

use Internal\Component\UrlComponents;
use RuntimeException;

class UrlParser
{
    /**
     * URL をパースして結果のオブジェクトを返します。
     *
     * @param string $requestUri
     * @param string $entrypoint
     *
     * @return UrlComponents
     */
    public function parse(string $requestUri, string $entrypoint): UrlComponents
    {
        $basename = $entrypoint;
        $uri = preg_replace(
            "#/$basename#",
            '',
            preg_replace('/(\/+)/', '/', $requestUri),
        );

        $components = parse_url($uri);
        if (!is_array($components)) {
            throw new RuntimeException("request uri is invalid: $requestUri");
        }

        return component(
            UrlComponents::class,
            [$components['path'] ?? '', $components['query'] ?? '', $components['fragment'] ?? ''],
        );
    }
}
