<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/08
 * Time: 22:43
 */

namespace Internal\Component;

use Internal\Component\Job\JobInterface;

class Workflow extends BaseComponent
{
    public ?JobInterface $head = null;
    public array $args = [];

    public function run(): void
    {
        $job = $this->head;
        while ($job !== null) {
            $job->execute(...$this->args);
            $job = $job->next;
        }
    }
}
