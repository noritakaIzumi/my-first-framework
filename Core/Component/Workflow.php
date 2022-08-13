<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/08
 * Time: 22:43
 */

namespace Core\Component;

class Workflow
{
    public ?AbstractJob $head = null;
    public array $firstArguments = [];
    public mixed $artifacts = [];

    public function run(): mixed
    {
        $job = $this->head;
        if ($job !== null) {
            $this->artifacts = $job->execute($this->artifacts, ...$this->firstArguments);
            $job = $job->next;
        }
        while ($job !== null) {
            $this->artifacts = $job->execute($this->artifacts);
            $job = $job->next;
        }

        return $this->artifacts;
    }
}
