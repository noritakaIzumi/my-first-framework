<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/27
 * Time: 18:37
 */

namespace Internal\Shared\Database;

use Internal\Component\Database\Connection;

class Database
{
    public ?Connection $connection = null;

    public function connect(): static
    {
        $connectionInfo = shared(ConnectionInfo::class);
        $connectionInfo->setFromEnv();
        $this->connection = component(Connection::class, [
            [
                'type' => $connectionInfo->getType(),
                'host' => $connectionInfo->getHost(),
                'database' => $connectionInfo->getDatabase(),
                'username' => $connectionInfo->getUsername(),
                'password' => $connectionInfo->getPassword(),
            ]
        ]);

        return $this;
    }

    public function disconnect(): static
    {
        $this->connection = null;

        return $this;
    }
}
