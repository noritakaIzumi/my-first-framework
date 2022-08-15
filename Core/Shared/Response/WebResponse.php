<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/11
 * Time: 07:40
 */

namespace Core\Shared\Response;

class WebResponse implements ResponseInterface
{
    public $headerStruct;
    /**
     * @var array
     */
    public array $headers = [];

    public function __construct()
    {
        $this->headerStruct = new class {
            public string $header;
            public bool $replace;
            public int $responseCode;
        };
    }

    public function setHeader(string $header, bool $replace = true, int $responseCode = 0): void
    {
        $struct = clone $this->headerStruct;
        $struct->header = $header;
        $struct->replace = $replace;
        $struct->responseCode = $responseCode;

        $this->headers[] = $struct;
    }

    public function setContentType(string $contentType): void
    {
        $this->setHeader("Content-Type: $contentType");
    }

    public function output(mixed $artifacts): void
    {
        $output = match (true) {
            is_object($artifacts) || is_array($artifacts) => json_encode($artifacts, JSON_THROW_ON_ERROR),
            !is_string($artifacts) => (string)$artifacts,
            default => $artifacts,
        };

        foreach ($this->headers as $header) {
            $header instanceof $this->headerStruct or trigger_error('', E_USER_ERROR);
            header($header->header, $header->replace, $header->responseCode);
        }
        echo $output;
    }
}