<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/07
 * Time: 08:06
 */

namespace Cmd;

use Internal\Factory\ComponentFactory;
use Internal\Factory\SharedFactory;
use Internal\Shared\Response\WebResponse;
use Internal\Shared\UrlParser;
use JsonException;

class WebCmd extends AbstractCmd
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
        $path = $this->getNormalizedPath($requestUri);
        $workflow = $this->getWorkflow($requestMethod, $path);

        $output = $workflow->run();
        try {
            shared(WebResponse::class)->output($output ?? '');
        } catch (JsonException $e) {
            logger()->error($e->getMessage());
        }

        // reset factory
        ComponentFactory::reset();
        SharedFactory::reset();
    }

    protected function getNormalizedPath(string $requestUri): string
    {
        /** @var UrlParser $urlParser */
        $urlParser = shared(UrlParser::class);

        return $urlParser->parse($requestUri, $this->entrypoint)->getPath();
    }
}
