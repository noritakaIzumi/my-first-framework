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
            $connection = component(Connection::class, [ConnectionInfo::createFromEnv($profile)]);
            $this->connectionPool[$profile] = $connection;
            return $connection;
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
