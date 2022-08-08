<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/08
 * Time: 22:43
 */

namespace Application;

class Job
{
    public ?Job $next = null;
    public Workflow $parent;

    public function execute(): void
    {
    }
}
