<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/27
 * Time: 18:37
 */

namespace Internal\Shared\Database;

use Internal\Component\Database\Connection;
use Internal\Component\Database\ConnectionInfo;
use InvalidArgumentException;

class Database
{
    /**
     * @var Connection[]
     */
    public array $connectionPool = [];

    /**
     * @param string $profile
     * @return Connection
     */
    public function connect(string $profile = 'default'): Connection
    {
        if ($profile === 'default') {
            $connectionInfo = component(ConnectionInfo::class);
            $connectionInfo->setFromEnv();
            $this->connectionPool[$profile] = component(Connection::class, [
                [
                    'type' => $connectionInfo->getType(),
                    'host' => $connectionInfo->getHost(),
                    'database' => $connectionInfo->getDatabase(),
                    'username' => $connectionInfo->getUsername(),
                    'password' => $connectionInfo->getPassword(),
                ]
            ]);
            return $this->connectionPool[$profile];
        }

        throw new InvalidArgumentException("the db profile $profile does not exist");
    }

    public function disconnect(string $profile = 'default'): void
    {
        $this->connectionPool[$profile] = null;
    }

    public function disconnectAll(): void
    {
        $this->connectionPool = [];
    }
}
