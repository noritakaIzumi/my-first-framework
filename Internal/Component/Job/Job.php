<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/09/11
 * Time: 17:45
 */

namespace Internal\Component\Job;

use Internal\Factory\SharedFactory;
use Internal\Shared\Database\Database;

class Job implements JobInterface
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

    public function execute($artifacts, ...$args): mixed
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
        SharedFactory::getInstance(Database::class)->disconnect();
    }
}
