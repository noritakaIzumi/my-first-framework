<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/11
 * Time: 21:04
 */

namespace Internal\Factory;

interface MockInterface
{
    /**
     * クラスのインスタンスをモックするときはこのメソッドを使います。
     *
     * @param string $className
     * @param object $mock
     *
     * @return void
     */
    public static function injectMock(string $className, object $mock): void;

    /**
     * クラスの定義をオーバーライドするときはこのメソッドを使います。
     *
     * @param string $className
     * @param string $overrideClassName
     *
     * @return void
     */
    public static function overrideClass(string $className, string $overrideClassName): void;

    /**
     * @template _T
     *
     * @param class-string<_T> $className       クラス名
     * @param array            $constructorArgs コンストラクタの引数
     *
     * @return _T
     */
    public static function getInstance(string $className, array $constructorArgs = []): object;
}
