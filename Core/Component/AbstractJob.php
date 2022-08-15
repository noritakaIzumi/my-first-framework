<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/11
 * Time: 20:02
 */

namespace Core\Component;

abstract class AbstractJob
{
    public ?self $next = null;

    /**
     * @var callable
     */
    protected $func;

    public function __construct(?callable $value = null)
    {
        $this->func = $value;
    }

    abstract public function execute($artifacts, ...$args);
}
