<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/08
 * Time: 22:43
 */

namespace Core;

class Job
{
    public ?Job $next = null;
    /**
     * @var callable|array
     */
    private $func;
    private array $args = [];

    public function __construct(callable|array $value = null)
    {
        if (is_callable($value)) {
            $this->func = $value;

            return;
        }
        if (is_array($value)) {
            $this->func = $value[0];
            $this->args = $value[1] ?? [];

            return;
        }

        trigger_error('エラー', E_USER_ERROR);
    }

    public function execute(mixed $artifacts): mixed
    {
        if ($this->func === null) {
            return null;
        }

        return call_user_func($this->func, $artifacts, ...$this->args);
    }
}
