<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/07
 * Time: 08:06
 */

namespace Command;

use Core\Store\Cookie;
use Core\Store\Request;
use Core\Component\Workflow;
use Core\Factory\Service;
use Core\Service\Response;
use Core\Service\Router;
use Core\Service\Routes;
use Core\Service\UrlParser;

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
        Request::init();
        Cookie::init();
        foreach (glob(__DIR__ . '/../config/*.php') as $filepath) {
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
            $urlParser = Service::get(UrlParser::class);

            return $urlParser->parse($requestUri, $this->entrypoint)->getPath();
        })(
            $requestUri
        );

        // get workflow by path
        $workflow = (static function (string $requestMethod, string $path): Workflow {
            /** @var Router $router */
            $router = Service::get(Router::class, [Service::get(Routes::class)]);

            return $router->getWorkflow($requestMethod, $path);
        })(
            $requestMethod,
            $path
        );

        // run
        (static function (Workflow $workflow): void {
            $artifacts = $workflow->run();

            /** @var Response $response */
            $response = Service::get(Response::class);
            $response->output($artifacts);
        })(
            $workflow
        );
    }
}
