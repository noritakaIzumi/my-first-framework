<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/11
 * Time: 21:04
 */

namespace Core\Factory;

interface MockInterface
{
    /**
     * @param string $className
     * @param object $mock
     *
     * @return void
     */
    public static function register(string $className, object $mock): void;

    /**
     * @template _T
     *
     * @param class-string<_T> $className       クラス名
     * @param array            $constructorArgs コンストラクタの引数
     *
     * @return _T
     */
    public static function get(string $className, array $constructorArgs = []): object;
}
