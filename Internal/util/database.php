<?php

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
