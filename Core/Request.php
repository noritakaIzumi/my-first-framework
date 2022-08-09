<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/10
 * Time: 06:15
 */

namespace Core;

class Request
{
    private static ?array $_get = null;
    private static ?array $_post = null;
    private static ?array $_request = null;

    public static function init(?array $_get = null, ?array $_post = null, ?array $_request = null): void
    {
        if (self::$_get === null) {
            self::$_get = $_get ?? $_GET;
        } else {
            // TODO: get param がすでにセットされているのでスキップしますのログ
        }

        if (self::$_post === null) {
            self::$_post = $_post ?? $_POST;
        } else {
            // TODO: post param がすでにセットされているのでスキップしますのログ
        }

        if (self::$_request === null) {
            self::$_request = $_request ?? $_REQUEST;
        } else {
            // TODO: post param がすでにセットされているのでスキップしますのログ
        }
    }

    /**
     * GET パラメータを取得します。
     *
     * @param string|null $key     キー
     * @param mixed|null  $default キーが存在しない場合に返す値。
     *
     * @return mixed キーに対応する値。キーを指定しない場合 GET パラメータそのもの。
     */
    public static function get(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return self::$_get;
        }

        return self::$_get[$key] ?? $default;
    }

    /**
     * POST パラメータを取得します。
     *
     * @param string|null $key     キー
     * @param mixed|null  $default キーが存在しない場合に返す値。
     *
     * @return mixed キーに対応する値。キーを指定しない場合 POST パラメータそのもの。
     */
    public static function post(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return self::$_post;
        }

        return self::$_post[$key] ?? $default;
    }

    /**
     * REQUEST パラメータを取得します。
     *
     * @param string|null $key     キー
     * @param mixed|null  $default キーが存在しない場合に返す値。
     *
     * @return mixed キーに対応する値。キーを指定しない場合 REQUEST パラメータそのもの。
     */
    public static function request(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return self::$_request;
        }

        return self::$_request[$key] ?? $default;
    }

    public static function reset(): void
    {
        self::$_get = null;
        self::$_post = null;
        self::$_request = null;
    }
}
