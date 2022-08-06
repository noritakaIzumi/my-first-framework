<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/06
 * Time: 11:01
 */

namespace App;

use HttpRuntimeException;
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
     * URL をパースします。
     *
     * @return array|false パース結果。パースに失敗した場合は false を返します。
     */
    public function parse(): array|false
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

        return $components;
    }
}
