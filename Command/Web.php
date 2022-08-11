<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/07
 * Time: 08:06
 */

namespace Command;

use Core\Cookie;
use Core\Factory;
use Core\Request;
use Core\Response;
use Core\Router;
use Core\Routes;
use Core\SharedServices;
use Core\UrlParser;
use Core\Workflow;

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

    public function run(string $requestMethod, string $requestUri): void
    {
        // get normalized path
        $path = (function (string $requestUri): string {
            /** @var UrlParser $urlParser */
            $urlParser = Factory::get(
                UrlParser::class,
                [$requestUri, $this->entrypoint],
            );

            return $urlParser->parse()->getPath();
        })(
            $requestUri
        );

        // get workflow by path
        $workflow = (static function (string $requestMethod, string $path): Workflow {
            /** @var Router $router */
            $router = SharedServices::get(Router::class, [SharedServices::get(Routes::class)]);

            return $router->getWorkflow($requestMethod, $path);
        })(
            $requestMethod,
            $path
        );

        // run
        (static function (Workflow $workflow): void {
            $artifacts = $workflow->run();

            /** @var Response $response */
            $response = Factory::get(Response::class);
            $response->output($artifacts);
        })(
            $workflow
        );
    }
}
