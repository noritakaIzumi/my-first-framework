<?php

namespace Internal\Factory;

class FactoryForge implements ManageFactoryInterface
{
    public static function save(): void
    {
        ComponentFactory::save();
        SharedFactory::save();
        CmdFactory::save();
    }

    public static function reset(): void
    {
        ComponentFactory::reset();
        SharedFactory::reset();
        CmdFactory::reset();
    }
}
