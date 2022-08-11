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
        $requestMethod = strtolower($requestMethod);
        $callables = match ($requestMethod) {
            'get', 'post' => $this->matchPath($requestMethod, $path),
            default => trigger_error('method not allowed', E_USER_ERROR),
        };

        /** @var WorkflowBuilder $workflowBuilder */
        $workflowBuilder = SharedFactory::getInstance(WorkflowBuilder::class);

        return $workflowBuilder->build($callables);
    }

    /**
     * @param string $requestMethod
     * @param string $path
     *
     * @return array|callable[]
     * @todo 正規表現の replacement = $n 等の対応
     */
    protected function matchPath(string $requestMethod, string $path): array
    {
        $paths = match ($requestMethod) {
            'get' => $this->routes->get,
            'post' => $this->routes->post,
            default => [],
        };

        foreach ($paths as $pattern => $jobs) {
            $replaced = preg_replace("#^$pattern$#", '', $path);
            if ($replaced === '') {
                return $jobs;
            }
        }

        return [];
    }
}
