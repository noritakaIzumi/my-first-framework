<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/11
 * Time: 07:40
 */

namespace Internal\Shared\Response;

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
            header($header->header, $header->replace, $header->responseCode);
        }
        echo $output;
    }
}
