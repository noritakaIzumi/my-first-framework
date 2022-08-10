<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/07
 * Time: 08:06
 */

namespace Command;

use Core\Factory;
use Core\Request;
use Core\Response;
use Core\Router;
use Core\Routes;
use Core\UrlParser;

class Web
{
    public array $paths = [];
    public string $entrypoint;
    public array $cookie;

    /**
     * @param string $entrypoint このクラスを実行するファイルパス。
     */
    public function __construct(string $entrypoint)
    {
        $this->paths['ROOT_PATH'] = dirname($entrypoint);
        $this->paths['APP_PATH'] = __DIR__;
        $this->entrypoint = preg_replace("#^{$this->paths['ROOT_PATH']}#", '', $entrypoint);
        Request::init();
        // TODO: cookie を取得したりセットしたりするクラスを作成する
        $this->cookie = $_COOKIE;
        foreach (glob(__DIR__ . '/../config/*.php') as $filepath) {
            require_once $filepath;
        }
    }

    public function run(string $requestUri): void
    {
        /** @var UrlParser $urlParser */
        $urlParser = Factory::get(
            UrlParser::class,
            [$requestUri, $this->entrypoint],
        );
        $urlComponents = $urlParser->parse();
        $path = $urlComponents->getPath();

        /** @var Router $router */
        $router = Factory::get(Router::class, [Factory::get(Routes::class)]);
        $workflow = $router->getWorkflow($path);

        $artifacts = $workflow->run();

        /** @var Response $response */
        $response = Factory::get(Response::class);
        $response->output($artifacts);
    }
}
