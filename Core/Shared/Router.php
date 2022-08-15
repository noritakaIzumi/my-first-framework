<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/08
 * Time: 22:57
 */

namespace Core\Shared;

use Core\Component\MatchedPath;
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
        $matchedPath = match ($requestMethod) {
            'get', 'post' => $this->matchPath($requestMethod, $path),
            default => trigger_error('method not allowed', E_USER_ERROR),
        };

        /** @var WorkflowBuilder $workflowBuilder */
        $workflowBuilder = SharedFactory::getInstance(WorkflowBuilder::class);

        return $workflowBuilder->build($matchedPath);
    }

    /**
     * @param string $requestMethod
     * @param string $path
     *
     * @return MatchedPath
     */
    protected function matchPath(string $requestMethod, string $path): MatchedPath
    {
        $routes = match ($requestMethod) {
            'get' => $this->routes->get,
            'post' => $this->routes->post,
            default => [],
        };

        foreach ($routes as $route) {
            $pattern = '/' . trim($route->pattern, '/');
            $replacement = trim($route->replacement, '/');
            $path = '/' . trim($path, '/');

            $replaced = preg_replace("#^$pattern$#", $replacement, $path);
            if ($replaced !== $path) {
                return new MatchedPath(
                    $route->callbacks,
                    explode('/', $replacement !== '' ? $replacement : ltrim($path, '/')),
                );
            }
        }

        return new MatchedPath([], []);
    }
}
