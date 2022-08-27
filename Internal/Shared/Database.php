<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/27
 * Time: 18:37
 */

namespace Internal\Shared;

use Medoo\Medoo;

class Database
{
    public ?Medoo $db = null;

    public function connect(): static
    {
        // TODO: 環境変数に切り出す
        $this->db = new Medoo([
            'type' => 'pgsql',
            'host' => 'db',
            'database' => 'postgres',
            'username' => 'postgres',
            'password' => 'password',
        ]);

        return $this;
    }

    public function disconnect(): static
    {
        $this->db = null;

        return $this;
    }
}
