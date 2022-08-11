<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/11
 * Time: 21:07
 */

namespace Core;

class SharedServices implements MockStoreInterface
{
    /**
     * @var array<class-string, object>
     */
    private static array $mocks = [];

    /**
     * @inheritDoc
     */
    public static function register(string $className, object $mock): void
    {
        self::$mocks[$className] = $mock;
    }

    /**
     * @inheritDoc
     */
    public static function get(string $className, array $constructorArgs = []): object
    {
        return self::$mocks[$className] ?? new $className(...$constructorArgs);
    }
}
