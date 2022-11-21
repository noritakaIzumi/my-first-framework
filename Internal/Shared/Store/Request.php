<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/10
 * Time: 06:15
 */

namespace Internal\Shared\Store;

class Request extends AbstractParameterStore
{
    private ?array $_get;
    private ?array $_post;
    private ?array $_request;

    /**
     * @param array|null $_get
     * @param array|null $_post
     * @param array|null $_request
     *
     * @return void
     */
    public function __construct(?array $_get = null, ?array $_post = null, ?array $_request = null)
    {
        $this->_get = $_get ?? $_GET;
        $this->_post = $_post ?? $_POST;
        $this->_request = $_request ?? $_REQUEST;
    }

    /**
     * GET パラメータを取得します。
     *
     * @param string|null $key     キー
     * @param mixed|null  $default キーが存在しない場合に返す値。
     *
     * @return mixed キーに対応する値。キーを指定しない場合 GET パラメータそのもの。
     */
    public function getGet(?string $key = null, mixed $default = null): mixed
    {
        return self::getDictValueByKey($this->_get, $key, $default);
    }

    /**
     * POST パラメータを取得します。
     *
     * @param string|null $key     キー
     * @param mixed|null  $default キーが存在しない場合に返す値。
     *
     * @return mixed キーに対応する値。キーを指定しない場合 POST パラメータそのもの。
     */
    public function getPost(?string $key = null, mixed $default = null): mixed
    {
        return self::getDictValueByKey($this->_post, $key, $default);
    }

    /**
     * REQUEST パラメータを取得します。
     *
     * @param string|null $key     キー
     * @param mixed|null  $default キーが存在しない場合に返す値。
     *
     * @return mixed キーに対応する値。キーを指定しない場合 REQUEST パラメータそのもの。
     */
    public function getRequest(?string $key = null, mixed $default = null): mixed
    {
        return self::getDictValueByKey($this->_request, $key, $default);
    }

    /**
     * @param array|null $get
     */
    public function setGet(?array $get): void
    {
        $this->_get = $get;
    }

    /**
     * @param array|null $post
     */
    public function setPost(?array $post): void
    {
        $this->_post = $post;
    }

    /**
     * @param array|null $request
     */
    public function setRequest(?array $request): void
    {
        $this->_request = $request;
    }

    public function reset(): void
    {
        $this->_get = null;
        $this->_post = null;
        $this->_request = null;
    }
}
