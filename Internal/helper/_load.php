<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/09/11
 * Time: 20:04
 */

use Internal\Factory\ComponentFactory;
use Internal\Factory\SharedFactory;

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
