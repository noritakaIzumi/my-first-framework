<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/09/11
 * Time: 20:00
 */

use Internal\Component\Database\Dbh;
use Internal\Shared\Database\Database;

if (!function_exists('connectDatabase')) {
    /**
     * データベースへ接続します。
     *
     * @return Dbh
     */
    function connectDatabase(): Dbh
    {
        $database = shared(Database::class);
        $database->connect();

        return $database->connection->dbh;
    }
}
