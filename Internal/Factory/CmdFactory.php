<?php

namespace Internal\Factory;

class CmdFactory extends BaseFactory implements OverloadClassInterface
{
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
        if (isset(self::$overloads[$className])) {
            $className = self::$overloads[$className];
        }

        return new $className(...$constructorArgs);
    }
}
