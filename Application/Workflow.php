<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/08
 * Time: 22:43
 */

namespace Application;

class Workflow
{
    public ?Job $head = null;
    public mixed $artifacts = null;

    public function run(): mixed
    {
        $job = $this->head;
        while ($job !== null) {
            $this->artifacts = $job->execute($this->artifacts);
            $job = $job->next;
        }

        return $this->artifacts;
    }
}
