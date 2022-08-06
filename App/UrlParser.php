<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/06
 * Time: 11:01
 */

namespace App;

use RuntimeException;

class UrlParser
{
    private string $filepath;
    private string $requestUri;

    /**
     * @param string $filepath
     * @param string $requestUri
     */
    public function __construct(string $filepath, string $requestUri)
    {
        $this->filepath = $filepath;
        $this->requestUri = $requestUri;
    }

    /**
     * URL をパースして結果のオブジェクトを返します。
     *
     * @return UrlComponents
     */
    public function parse(): UrlComponents
    {
        $basename = basename($this->filepath);
        $uri = preg_replace(
            "#/$basename#",
            '',
            preg_replace(
                '/(\/+)/',
                '/',
                $this->requestUri,
            ),
        );

        $components = parse_url($uri);
        if (!is_array($components)) {
            throw new RuntimeException("request uri is invalid: $this->requestUri");
        }

        return Factory::get(
            UrlComponents::class,
            $components['path'] ?? '',
            $components['query'] ?? '',
            $components['fragment'] ?? '',
        );
    }
}
