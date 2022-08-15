<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/07
 * Time: 08:06
 */

namespace Cmd;

use Internal\Component\Workflow;
use Internal\Factory\SharedFactory;
use Internal\Shared\Response\WebResponse;
use Internal\Shared\Router;
use Internal\Shared\Routes;
use Internal\Shared\UrlParser;

class Web
{
    public array $paths = [];
    public string $entrypoint;

    /**
     * @param string $entrypoint このクラスを実行するファイルパス。
     */
    public function __construct(string $entrypoint)
    {
        $this->paths['ROOT_PATH'] = dirname($entrypoint);
        $this->paths['APP_PATH'] = __DIR__;
        $this->entrypoint = preg_replace("#^{$this->paths['ROOT_PATH']}#", '', $entrypoint);
        foreach (glob(__DIR__ . '/../configs/*.php') as $filepath) {
            require_once $filepath;
        }
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
            $urlParser = SharedFactory::getInstance(UrlParser::class);

            return $urlParser->parse($requestUri, $this->entrypoint)->getPath();
        })(
            $requestUri
        );

        // get workflow by path
        $workflow = (static function (string $requestMethod, string $path): Workflow {
            /** @var Router $router */
            $router = SharedFactory::getInstance(Router::class, [SharedFactory::getInstance(Routes::class)]);

            return $router->getWorkflow($requestMethod, $path);
        })(
            $requestMethod,
            $path
        );

        // run
        (static function (Workflow $workflow): void {
            $artifacts = $workflow->run();

            /** @var WebResponse $response */
            $response = SharedFactory::getInstance(WebResponse::class);
            $response->output($artifacts);
        })(
            $workflow
        );
    }
}
