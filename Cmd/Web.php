<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/07
 * Time: 08:06
 */

namespace Cmd;

use Internal\Component\Workflow;
use Internal\Factory\ComponentFactory;
use Internal\Factory\SharedFactory;
use Internal\Shared\Response\WebResponse;
use Internal\Shared\Router;
use Internal\Shared\Routes;
use Internal\Shared\UrlParser;

class Web extends AbstractCmd
{
    public array $paths = [];
    public string $entrypoint;

    /**
     * @param string $entrypoint このクラスを実行するファイルパス。
     */
    public function __construct(string $entrypoint)
    {
        parent::__construct();
        $this->paths['ROOT_PATH'] = dirname($entrypoint);
        $this->entrypoint = preg_replace("#^{$this->paths['ROOT_PATH']}#", '', $entrypoint);
    }

    /**
     * @param string $requestMethod
     * @param string $requestUri
     *
     * @return void
     */
    public function run(string $requestMethod, string $requestUri): void
    {
        // get normalized path
        $path = (function (string $requestUri): string {
            /** @var UrlParser $urlParser */
            $urlParser = shared(UrlParser::class);

            return $urlParser->parse($requestUri, $this->entrypoint)->getPath();
        })(
            $requestUri
        );

        // get workflow by path
        $workflow = (static function (string $requestMethod, string $path): Workflow {
            /** @var Router $router */
            $router = shared(Router::class, [shared(Routes::class)]);

            return $router->getWorkflow($requestMethod, $path);
        })(
            $requestMethod,
            $path
        );

        // run
        (static function (Workflow $workflow): void {
            $output = $workflow->run();

            /** @var WebResponse $response */
            $response = shared(WebResponse::class);
            $response->output($output);
        })(
            $workflow
        );

        // reset factory
        ComponentFactory::reset();
        SharedFactory::reset();
    }
}
