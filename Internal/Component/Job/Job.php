<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/09/11
 * Time: 17:45
 */

namespace Internal\Component\Job;

use Internal\Component\BaseComponent;
use Internal\Shared\Database\Database;

class Job extends BaseComponent implements JobInterface
{
    /**
     * Next job
     *
     * @var JobInterface|null
     */
    public ?JobInterface $next = null;

    /**
     * @var callable
     */
    protected $func;

    /**
     * @param callable|null $func
     *
     * @return static
     */
    public function setScript(?callable $func): static
    {
        $this->func = $func;

        return $this;
    }

    public function execute(...$args): mixed
    {
        $this->beforeExecute();
        $output = call_user_func($this->func, ...func_get_args());
        $this->afterExecute();

        return $output;
    }

    protected function beforeExecute(): void
    {
    }

    protected function afterExecute(): void
    {
        shared(Database::class)->disconnect();
    }
}
