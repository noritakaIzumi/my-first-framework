<?php

namespace Internal\Shared;

use Internal\Component\Header;

class HttpHeadersSent
{
    /**
     * @var array<string, string[]>
     */
    protected array $headers = [];
    protected int $responseCode = 0;

    public function addHeader(Header $header): void
    {
        [$name, $value] = array_map(static fn(string $s): string => trim($s), explode(':', $header->header));
        if (!isset($this->headers[$name]) || $header->replace) {
            $this->headers[$name] = [$value];
        } else {
            $this->headers[$name][] = $value;
        }
        $this->responseCode = $header->responseCode;
    }

    /**
     * @return array<string, string[]>
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return int
     */
    public function getResponseCode(): int
    {
        return $this->responseCode;
    }
}
