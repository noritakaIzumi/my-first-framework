<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/07
 * Time: 05:40
 */

namespace Internal\Factory;

class ComponentFactory extends BaseFactory implements InjectMockInterface, OverloadClassInterface
{
    /**
     * @inheritDoc
     */
    public static function injectMock(string $className, object $mock): void
    {
        self::$mocks[$className] = $mock;
    }

    /**
     * @inheritDoc
     */
    public static function overloadClass(string $className, string $overloadClassName): void
    {
        self::$overloads[$className] = $overloadClassName;
    }

    /**
     * @inheritDoc
     */
    public static function getInstance(string $className, array $constructorArgs = []): object
    {
        if (isset(self::$mocks[$className])) {
            return clone self::$mocks[$className];
        }

        if (isset(self::$overloads[$className])) {
            $className = self::$overloads[$className];
        }

        return new $className(...$constructorArgs);
    }
}
