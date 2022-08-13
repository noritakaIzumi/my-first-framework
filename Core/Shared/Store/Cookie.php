<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/11
 * Time: 17:54
 */

namespace Core\Shared\Store;

class Cookie extends AbstractParameterStore
{
    public ?array $_cookie = null;

    /**
     * @param array|null $_cookie
     */
    public function __construct(?array $_cookie = null)
    {
        $this->_cookie = $_cookie ?? $_COOKIE;
    }

    /**
     * Cookie パラメータを取得します。
     *
     * @param string|null $key     キー
     * @param mixed|null  $default キーが存在しない場合に返す値。
     *
     * @return mixed キーに対応する値。キーを指定しない場合 Cookie 全体を配列で返します。
     */
    public function get(?string $key = null, mixed $default = null): mixed
    {
        return self::getDictValueByKey($this->_cookie, $key, $default);
    }

    public function reset(): void
    {
        $this->_cookie = null;
    }
}
