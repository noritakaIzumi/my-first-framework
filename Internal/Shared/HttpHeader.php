<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/10/30
 * Time: 10:26
 */

namespace Internal\Shared;

use Internal\Component\Header;

class HttpHeader
{
    /**
     * @var Header[]
     */
    protected array $headers = [];

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function addHeader(string $header, bool $replace = true, int $responseCode = 0): void
    {
        $this->headers[] = component(Header::class)
            ->setHeader($header)
            ->setReplace($replace)
            ->setResponseCode($responseCode);
    }

    public function setContentType(string $contentType): void
    {
        $this->addHeader("Content-Type: $contentType");
    }
}
