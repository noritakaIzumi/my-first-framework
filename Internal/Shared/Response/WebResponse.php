<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/11
 * Time: 07:40
 */

namespace Internal\Shared\Response;

use Internal\Component\Header;
use Pkg\Json;

class WebResponse implements ResponseInterface
{
    /**
     * @var Header[]
     */
    public array $headers = [];

    public function setHeader(string $header, bool $replace = true, int $responseCode = 0): void
    {
        $this->headers[] = component(Header::class)
            ->setHeader($header)
            ->setReplace($replace)
            ->setResponseCode($responseCode);
    }

    public function setContentType(string $contentType): void
    {
        $this->setHeader("Content-Type: $contentType");
    }

    public function output(): void
    {
        $value = artifact()->get('output');

        $output = match (true) {
            is_object($value) || is_array($value) => Json::marshal($value),
            !is_string($value) => (string)$value,
            default => $value,
        };

        foreach ($this->headers as $header) {
            header($header->header, $header->replace, $header->responseCode);
        }
        echo $output;
    }
}
