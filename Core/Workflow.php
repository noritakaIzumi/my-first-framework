<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/08
 * Time: 22:43
 */

namespace Core;

class Workflow
{
    public ?AbstractJob $head = null;
    public mixed $artifacts = [];

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
