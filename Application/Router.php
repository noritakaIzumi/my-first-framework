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
    public Routes $routes;

    public function __construct(Routes $routes)
    {
        $this->routes = $routes;
    }

    public function getWorkflow(string $path): Workflow
    {
        // TODO: パスの解析
        $callables = $this->routes->get[$path] ?? [];

        return WorkflowBuilder::build($callables);
    }
}
