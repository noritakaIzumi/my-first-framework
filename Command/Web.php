<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/07
 * Time: 08:06
 */

namespace Command;

use Application\Factory;
use Application\UrlParser;

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
        $this->entrypoint = preg_replace("#^{$this->paths['ROOT_PATH']}#", '', $entrypoint);
    }

    public function run(string $requestUri): void
    {
        $urlParser = Factory::get(UrlParser::class, $requestUri, $this->entrypoint);
        $urlComponents = $urlParser->parse();

        $path = $urlComponents->getPath();
        $query = $urlComponents->getQuery();
        $fragment = $urlComponents->getFragment();

        // TODO: ルーティングの処理を作る

        return;
    }
}
