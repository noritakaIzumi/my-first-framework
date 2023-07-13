<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/11
 * Time: 07:40
 */

namespace Internal\Shared\Response;

use Internal\Component\Header;
use Internal\Shared\HttpHeadersSent;
use Pkg\Json;

class WebResponse implements ResponseInterface
{
    public function respond(): void
    {
        $value = artifact()->get('output');

        $output = match (true) {
            is_object($value) || is_array($value) => Json::marshal($value),
            !is_string($value) => (string)$value,
            default => $value,
        };

        foreach (httpHeader()->getHeaders() as $header) {
            $this->header($header);
        }
        echo $output;
    }

    protected function header(Header $header): void
    {
        header($header->header, $header->replace, $header->responseCode);
        // TODO: ここはテスト環境のみの処理としたい
        shared(HttpHeadersSent::class)->addHeader($header);
    }
}
