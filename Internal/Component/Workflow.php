<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/08
 * Time: 22:43
 */

namespace Internal\Component;

use Internal\Component\Job\JobInterface;

class Workflow
{
    public ?JobInterface $head = null;
    public array $args = [];
    public mixed $output = '';

    public function run(): mixed
    {
        $job = $this->head;
        while ($job !== null) {
            $this->output = $job->execute(...$this->args);
            $job = $job->next;
        }

        return $this->output;
    }
}
