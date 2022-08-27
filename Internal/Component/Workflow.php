<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/08
 * Time: 22:43
 */

namespace Internal\Component;

class Workflow
{
    public ?AbstractJob $head = null;
    public array $args = [];
    public mixed $artifacts = '';

    public function run(): mixed
    {
        $job = $this->head;
        if ($job !== null) {
            $this->artifacts = $job->execute(...$this->args);
            $job->afterExecute();
            $job = $job->next;
        }
        while ($job !== null) {
            $this->artifacts = $job->execute($this->artifacts, ...$this->args);
            $job->afterExecute();
            $job = $job->next;
        }

        return $this->artifacts;
    }
}
