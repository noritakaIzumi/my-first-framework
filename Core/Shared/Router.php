<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/08
 * Time: 22:57
 */

namespace Core\Shared;

use Core\Component\Workflow;
use Core\Factory\SharedFactory;

class Router
{
    public Routes $routes;

    public function __construct(Routes $routes)
    {
        $this->routes = $routes;
    }

    /**
     * @param string $requestMethod
     * @param string $path
     *
     * @return Workflow
     */
    public function getWorkflow(string $requestMethod, string $path): Workflow
    {
        $callables = match (strtolower($requestMethod)) {
            'get' => $this->routes->get[$path] ?? [],
            'post' => $this->routes->post[$path] ?? [],
            default => trigger_error('method not allowed', E_USER_ERROR),
        };

        /** @var WorkflowBuilder $workflowBuilder */
        $workflowBuilder = SharedFactory::get(WorkflowBuilder::class);

        return $workflowBuilder->build($callables);
    }
}
