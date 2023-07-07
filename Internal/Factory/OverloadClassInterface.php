<?php

namespace Internal\Factory;

interface OverloadClassInterface
{
    /**
     * クラスの定義をオーバーロードするときはこのメソッドを使います。
     *
     * @param string $className
     * @param string $overloadClassName
     *
     * @return void
     */
    public static function overloadClass(string $className, string $overloadClassName): void;

    /**
     * @template _T
     *
     * @param class-string<_T> $className クラス名
     * @param array $constructorArgs コンストラクタの引数
     *
     * @return _T
     */
    public static function getInstance(string $className, array $constructorArgs = []): object;
}
