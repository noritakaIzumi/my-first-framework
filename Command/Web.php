<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/07
 * Time: 08:06
 */

namespace Command;

use Application\Factory;
use Application\Router;
use Application\UrlParser;
use Application\Workflow;

class Web
{
    public array $paths = [];
    public string $entrypoint;
    public array $request;
    public array $cookie;

    public Workflow $workflow;

    /**
     * @param string $entrypoint このクラスを実行するファイルパス。
     */
    public function __construct(string $entrypoint)
    {
        $this->paths['ROOT_PATH'] = dirname($entrypoint);
        $this->entrypoint = preg_replace("#^{$this->paths['ROOT_PATH']}#", '', $entrypoint);
        $this->request = [
            'get' => $_GET,
            'post' => $_POST,
            'request' => $_REQUEST,
        ];
        $this->cookie = $_COOKIE;
    }

    public function run(string $requestUri): void
    {
        $urlParser = Factory::get(
            UrlParser::class,
            [$requestUri, $this->entrypoint],
        );
        $urlComponents = $urlParser->parse();

        /** @var Router $router */
        $router = Factory::get(Router::class);
        $this->workflow = $router->getWorkflow($urlComponents->getPath());

        $job = $this->workflow->head;
        while ($job !== null) {
            $job->execute();
            $job = $job->next;
        }

        echo json_encode($this->workflow->artifacts);
    }
}
