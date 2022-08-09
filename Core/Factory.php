<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/07
 * Time: 05:40
 */

namespace Core;

class Factory
{
    /**
     * @var array<class-string, mixed>
     */
    private static array $mocks;

    public static function register(string $className, mixed $mock): void
    {
        self::$mocks[$className] = $mock;
    }

    /**
     * @template _T
     *
     * @param class-string<_T> $className       クラス名
     * @param array            $constructorArgs コンストラクタの引数
     *
     * @return _T
     */
    public static function get(string $className, array $constructorArgs = []): mixed
    {
        return self::$mocks[$className] ?? new $className(...$constructorArgs);
    }
}
