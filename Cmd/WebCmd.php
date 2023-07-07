<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/07
 * Time: 08:06
 */

namespace Cmd;

use Internal\Shared\Response\WebResponse;
use Internal\Shared\Store\Request;
use Internal\Shared\UrlParser;

use function shared;

class WebCmd extends AbstractCmd
{
    /**
     * エントリポイント
     *
     * @var string
     */
    protected string $entrypoint;
    /**
     * GET パラメータを $_GET からではなく URL の解析によって取得する場合、これを true にする。
     *
     * @var bool
     */
    protected bool $getQueryFromUrl = false;

    /**
     * @param string $entrypoint
     */
    public function __construct(string $entrypoint)
    {
        parent::__construct();
        $this->entrypoint = $entrypoint;
    }

    /**
     * GET パラメータを $_GET からではなく URL の解析によって取得する場合、これを true にする。
     *
     * @param bool $getQueryFromUrl
     *
     * @return WebCmd
     */
    public function setGetQueryFromUrl(bool $getQueryFromUrl): WebCmd
    {
        $this->getQueryFromUrl = $getQueryFromUrl;

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
        $urlComponents = shared(UrlParser::class)->parse($requestUri, $this->entrypoint);

        if ($this->getQueryFromUrl) {
            parse_str($urlComponents->getQuery(), $result);
            shared(Request::class)->setGet($result);
        }

        $path = $urlComponents->getPath();
        $this->getWorkflow($requestMethod, $path)->run();

        // ワークフロー内から他のワークフローを呼び出すことを想定し、レスポンスは独立させる
        shared(WebResponse::class)->respond();
    }

}
