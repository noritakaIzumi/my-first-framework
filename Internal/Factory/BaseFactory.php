<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/28
 * Time: 05:13
 */

namespace Internal\Factory;

abstract class BaseFactory implements ManageFactoryInterface
{
    /**
     * @var array<class-string, object>
     */
    protected static array $mocks = [];

    /**
     * @var array<class-string, class-string>
     */
    protected static array $overloads = [];

    /**
     * @var array<class-string, object>
     */
    protected static array $saveMocks = [];

    /**
     * @var array<class-string, class-string>
     */
    protected static array $saveOverloads = [];

    public static function save(): void
    {
        self::$saveMocks = self::$mocks;
        self::$saveOverloads = self::$overloads;
    }

    public static function reset(): void
    {
        self::$mocks = self::$saveMocks;
        self::$overloads = self::$saveOverloads;
    }
}
