<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/28
 * Time: 05:13
 */

namespace Internal\Factory;

abstract class BaseFactory
{
    /**
     * @var array<class-string, object>
     */
    protected static array $mocks = [];

    public static function reset(): void
    {
        self::$mocks = [];
    }
}
