<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/07
 * Time: 04:21
 */

namespace Internal\Component;

class UrlComponents
{
    private string $path;
    private string $query;
    private string $fragment;

    /**
     * @param string $path
     * @param string $query
     * @param string $fragment
     */
    public function __construct(string $path, string $query, string $fragment)
    {
        $this->path = $path;
        $this->query = $query;
        $this->fragment = $fragment;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @return string
     */
    public function getFragment(): string
    {
        return $this->fragment;
    }
}
