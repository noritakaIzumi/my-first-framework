<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/07
 * Time: 08:06
 */

namespace Cmd;

use Internal\Shared\Response\WebResponse;
use Internal\Shared\UrlParser;

class WebCmd extends AbstractCmd
{
    public string $entrypoint;

    /**
     * @param string $entrypoint
     *
     * @return WebCmd
     */
    public function setEntrypoint(string $entrypoint): WebCmd
    {
        $this->entrypoint = $entrypoint;

        return $this;
    }

    /**
     * @param string $requestMethod
     * @param string $requestUri
     *
     * @return void
     */
    public function run(string $requestMethod, string $requestUri): void
    {
        $path = $this->getNormalizedPath($requestUri);
        $this->getWorkflow($requestMethod, $path)->run();

        // ワークフロー内から他のワークフローを呼び出すことを想定し、レスポンスは独立させる
        shared(WebResponse::class)->respond();
    }

    protected function getNormalizedPath(string $requestUri): string
    {
        return shared(UrlParser::class)
            ->parse($requestUri, $this->entrypoint)
            ->getPath();
    }
}
