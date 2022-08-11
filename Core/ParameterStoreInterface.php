<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/11
 * Time: 21:59
 */

namespace Core;

interface ParameterStoreInterface
{
    /**
     * パラメータのセットや初期化を行います。
     *
     * @return void
     */
    public static function init(): void;
}
