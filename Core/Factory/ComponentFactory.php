<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/07
 * Time: 05:40
 */

namespace Core\Factory;

class ComponentFactory implements MockInterface
{
    /**
     * @var array<class-string, object>
     */
    private static array $mocks = [];

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
    public static function getInstance(string $className, array $constructorArgs = []): object
    {
        if (isset(self::$mocks[$className])) {
            return new self::$mocks[$className](...$constructorArgs);
        }

        return new $className(...$constructorArgs);
    }
}
