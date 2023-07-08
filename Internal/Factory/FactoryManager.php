<?php

namespace Internal\Factory;

class FactoryManager
{
    /**
     * @var class-string<BaseFactory>[]
     */
    protected array $factoryClassNames = [];

    public function __construct()
    {
        foreach (get_declared_classes() as $class) {
            if (is_subclass_of($class, BaseFactory::class) && str_starts_with($class, __NAMESPACE__)) {
                $this->factoryClassNames[] = $class;
            }
        }
    }

    public function save(): void
    {
        foreach ($this->factoryClassNames as $className) {
            $className::save();
        }
    }

    public function reset(): void
    {
        foreach ($this->factoryClassNames as $className) {
            $className::reset();
        }
    }
}
