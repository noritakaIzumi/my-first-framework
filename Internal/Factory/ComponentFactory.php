<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/07
 * Time: 05:40
 */

namespace Internal\Factory;

use Internal\Component\BaseComponent;

class ComponentFactory extends BaseFactory implements MockInterface
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
        if (!isset(self::$mocks[$className])) {
            return new $className(...$constructorArgs);
        }

        $class = clone self::$mocks[$className];
        if ($class instanceof BaseComponent && !$class->isConstructorExecuted()) {
            $class->__construct(...$constructorArgs);
        }

        return $class;
    }
}
