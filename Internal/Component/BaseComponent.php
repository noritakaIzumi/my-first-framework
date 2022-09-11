<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/09/11
 * Time: 18:59
 */

namespace Internal\Component;

abstract class BaseComponent
{
    private bool $constructorExecuted;

    public function __construct()
    {
        $this->constructorExecuted = true;
    }

    /**
     * @return bool
     */
    public function isConstructorExecuted(): bool
    {
        return isset($this->constructorExecuted);
    }
}
