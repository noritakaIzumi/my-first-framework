<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/28
 * Time: 02:49
 */

use Internal\Component\Database\Dbh;
use Internal\Factory\SharedFactory;
use Internal\Shared\Database\Database;

if (!function_exists('connectDatabase')) {
    /**
     * データベースへ接続します。
     *
     * @return Dbh
     */
    function connectDatabase(): Dbh
    {
        $database = SharedFactory::getInstance(Database::class);
        $database->connect();

        return $database->dbh;
    }
}
