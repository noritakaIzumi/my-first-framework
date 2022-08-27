<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/11
 * Time: 21:07
 */

namespace Internal\Factory;

class SharedFactory extends BaseFactory implements MockInterface
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
    public static function getInstance(string $className, array $constructorArgs = []): object
    {
        if (isset(self::$mocks[$className])) {
            return self::$mocks[$className];
        }

        $object = ComponentFactory::getInstance($className, $constructorArgs);
        self::injectMock($className, $object);

        return $object;
    }
}
