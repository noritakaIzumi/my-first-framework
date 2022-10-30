<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/10/28
 * Time: 16:52
 */

namespace Internal\Component;

class Header
{
    public string $header;
    public bool $replace;
    public int $responseCode;

    /**
     * @param string $header
     *
     * @return Header
     */
    public function setHeader(string $header): Header
    {
        $this->header = $header;

        return $this;
    }

    /**
     * @param bool $replace
     *
     * @return Header
     */
    public function setReplace(bool $replace): Header
    {
        $this->replace = $replace;

        return $this;
    }

    /**
     * @param int $responseCode
     *
     * @return Header
     */
    public function setResponseCode(int $responseCode): Header
    {
        $this->responseCode = $responseCode;

        return $this;
    }
}
