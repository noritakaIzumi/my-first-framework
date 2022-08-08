<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/08
 * Time: 22:57
 */

namespace Application;

class Router
{
    public function getWorkflow(string $getPath)
    {
        return Factory::get(Workflow::class);
    }
}
