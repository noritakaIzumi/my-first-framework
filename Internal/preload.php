<?php

use Internal\Factory\CmdFactory;
use Internal\Factory\ComponentFactory;
use Internal\Factory\SharedFactory;
use Internal\Shared\AbstractPathConfig;

/**
 * Shared サービスを読み込みます。
 *
 * @template _T
 *
 * @param class-string<_T> $className クラス名
 * @param array $constructorArgs コンストラクタの引数
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
 * @param class-string<_T> $className クラス名
 * @param array $constructorArgs コンストラクタの引数
 *
 * @return _T
 */
function component(string $className, array $constructorArgs = []): object
{
    return ComponentFactory::getInstance($className, $constructorArgs);
}

/**
 * エントリポイントクラスを読み込みます。
 *
 * @template _T
 *
 * @param class-string<_T> $className クラス名
 * @param array $constructorArgs コンストラクタの引数
 *
 * @return _T
 */
function cmd(string $className, array $constructorArgs = []): object
{
    return CmdFactory::getInstance($className, $constructorArgs);
}

/**
 * パス設定を取得します。
 * @return AbstractPathConfig
 */
function paths(): AbstractPathConfig
{
    return shared(AbstractPathConfig::class);
}
