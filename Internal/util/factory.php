<?php

use Internal\Component\Artifact;
use Internal\Shared\Artifacts;
use Internal\Shared\HttpHeader;
use Internal\Shared\Routes;
use Internal\Shared\Store\Request;

/*
 * shared
 */

if (!function_exists('routes')) {
    function routes(): Routes
    {
        return shared(Routes::class);
    }
}

if (!function_exists('request')) {
    function request(): Request
    {
        return shared(Request::class);
    }
}

if (!function_exists('httpHeader')) {
    function httpHeader(): HttpHeader
    {
        return shared(HttpHeader::class);
    }
}

/*
 * component
 */

if (!function_exists('artifact')) {
    /**
     * アーティファクトを取得します。
     *
     * @param string $name
     *
     * @return Artifact
     */
    function artifact(string $name = 'default'): Artifact
    {
        return shared(Artifacts::class)->getArtifact($name);
    }
}
