<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/28
 * Time: 02:56
 */

foreach (glob(__DIR__ . '/util/*.php') as $file) {
    require_once $file;
}
