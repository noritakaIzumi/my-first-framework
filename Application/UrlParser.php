<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/06
 * Time: 11:01
 */

namespace Application;

use RuntimeException;

class UrlParser
{
    private string $requestUri;
    private string $entrypoint;

    public function __construct(string $requestUri, string $entrypoint)
    {
        $this->requestUri = $requestUri;
        $this->entrypoint = $entrypoint;
    }

    /**
     * URL をパースして結果のオブジェクトを返します。
     *
     * @return UrlComponents
     */
    public function parse(): UrlComponents
    {
        $basename = $this->entrypoint;
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
            [$components['path'] ?? '', $components['query'] ?? '', $components['fragment'] ?? ''],
        );
    }
}
