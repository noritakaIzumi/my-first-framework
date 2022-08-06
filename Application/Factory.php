<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/07
 * Time: 05:40
 */

namespace Application;

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
     * @param class-string<_T> $className
     * @param mixed            $args
     *
     * @return _T|null
     */
    public static function get(string $className, ...$args): mixed
    {
        return self::$mocks[$className] ?? new $className(...$args);
    }
}
