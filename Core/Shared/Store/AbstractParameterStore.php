<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/14
 * Time: 04:28
 */

namespace Core\Shared\Store;

abstract class AbstractParameterStore
{
    /**
     * dict からパラメータを取得します。
     *
     * @param array       $dict    探したい dict
     * @param string|null $key     キー
     * @param mixed|null  $default キーが存在しない場合に返す値。
     *
     * @return mixed キーに対応する値。キーを指定しない場合 dict 全体を配列で返します。
     */
    protected static function getDictValueByKey(array $dict, ?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return $dict;
        }

        return $dict[$key] ?? $default;
    }
}
