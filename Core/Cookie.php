<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/11
 * Time: 17:54
 */

namespace Core;

class Cookie
{
    public static ?array $_cookie = null;

    public static function init(?array $_cookie = null): void
    {
        if (self::$_cookie === null) {
            self::$_cookie = $_cookie ?? $_COOKIE;
        } else {
            // TODO: get param がすでにセットされているのでスキップしますのログ
        }
    }

    /**
     * Cookie パラメータを取得します。
     *
     * @param string|null $key     キー
     * @param mixed|null  $default キーが存在しない場合に返す値。
     *
     * @return mixed キーに対応する値。キーを指定しない場合 Cookie 全体を配列で返します。
     */
    public static function get(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return self::$_cookie;
        }

        return self::$_cookie[$key] ?? $default;
    }
}
