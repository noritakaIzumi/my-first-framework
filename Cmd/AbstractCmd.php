<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/09/03
 * Time: 10:16
 */

namespace Cmd;

use Internal\Component\Workflow;
use Internal\Shared\Router;
use Internal\Shared\Routes;

abstract class AbstractCmd
{
    public function __construct()
    {
        $this->init();
    }

    protected function init(): void
    {
        set_error_handler('myErrorHandler');
    }

    protected function getWorkflow(string $requestMethod, string $path): Workflow
    {
        /** @var Router $router */
        $router = shared(Router::class, [shared(Routes::class)]);

        return $router->getWorkflow($requestMethod, $path);
    }
}
