<?php

use Internal\Component\Database\Dbh;
use Internal\Shared\Database\Database;

if (!function_exists('connectDatabase')) {
    /**
     * データベースへ接続します。
     *
     * @param string $profile
     * @return Dbh
     */
    function connectDatabase(string $profile = 'default'): Dbh
    {
        return shared(Database::class)->connect($profile)->dbh;
    }
}
