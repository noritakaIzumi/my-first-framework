<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/09/11
 * Time: 20:04
 */

use Internal\Component\Artifact;
use Internal\Factory\ComponentFactory;
use Internal\Factory\SharedFactory;
use Internal\Shared\Artifacts;
use Internal\Shared\Routes;
use Internal\Shared\Store\Request;

/**
 * Shared サービスを読み込みます。
 *
 * @template _T
 *
 * @param class-string<_T> $className       クラス名
 * @param array            $constructorArgs コンストラクタの引数
 *
 * @return _T
 */
function shared(string $className, array $constructorArgs = []): object
{
    return SharedFactory::getInstance($className, $constructorArgs);
}

/**
 * Component を読み込みます。
 *
 * @template _T
 *
 * @param class-string<_T> $className       クラス名
 * @param array            $constructorArgs コンストラクタの引数
 *
 * @return _T
 */
function component(string $className, array $constructorArgs = []): object
{
    return ComponentFactory::getInstance($className, $constructorArgs);
}

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
