<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/11
 * Time: 21:07
 */

namespace Core\Factory;

class Service implements MockInterface
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
        if (isset(self::$mocks[$className])) {
            return self::$mocks[$className];
        }

        $object = ComponentFactory::get($className, $constructorArgs);
        self::register($className, $object);

        return $object;
    }
}
