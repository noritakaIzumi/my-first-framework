<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/09/03
 * Time: 10:16
 */

namespace Cmd;

use Internal\Component\Workflow;
use Internal\Factory\CmdFactory;
use Internal\Factory\ComponentFactory;
use Internal\Factory\FactoryForge;
use Internal\Factory\SharedFactory;
use Internal\Shared\Router;
use Internal\Shared\Routes;
use RuntimeException;

abstract class AbstractCmd
{
    public function __construct()
    {
        $this->init();
    }

    protected function init(): void
    {
    }

    protected function getWorkflow(string $requestMethod, string $path): Workflow
    {
        return shared(Router::class, [shared(Routes::class)])
            ->getWorkflow($requestMethod, $path);
    }

    /**
     * reset factories.
     *
     * @return void
     */
    public function reset(): void
    {
        FactoryForge::reset();
    }
}
