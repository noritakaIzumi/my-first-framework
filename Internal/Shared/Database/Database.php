<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/27
 * Time: 18:37
 */

namespace Internal\Shared\Database;

use Internal\Component\Database\Dbh;
use Internal\Factory\ComponentFactory;
use Internal\Factory\SharedFactory;

class Database
{
    public ?Dbh $dbh = null;

    public function connect(): static
    {
        $connectionInfo = SharedFactory::getInstance(ConnectionInfo::class);
        $connectionInfo->setFromEnv();
        $this->dbh = ComponentFactory::getInstance(Dbh::class, [
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
        $this->dbh = null;

        return $this;
    }
}
