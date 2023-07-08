<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/28
 * Time: 01:45
 */

namespace Internal\Component\Database;

use Dotenv\Dotenv;

class ConnectionInfo
{
    public static function createFromEnv(string $profile = 'default'): static
    {
        $dotenv = Dotenv::createMutable(paths()->app, '.env');
        $env = $dotenv->load();

        $upperProfile = strtoupper($profile);
        $varNames = [
            'DB_TYPE' => "DB_TYPE_$upperProfile",
            'DB_HOST' => "DB_HOST_$upperProfile",
            'DB_NAME' => "DB_NAME_$upperProfile",
            'DB_USER' => "DB_USER_$upperProfile",
            'DB_PASS' => "DB_PASS_$upperProfile",
        ];

        $dotenv->ifPresent($varNames['DB_TYPE'])->notEmpty();
        $type = $env[$varNames['DB_TYPE']] ?? 'mysql';

        $dotenv->required([
            $varNames['DB_HOST'],
            $varNames['DB_NAME'],
            $varNames['DB_USER'],
            $varNames['DB_PASS']
        ])->notEmpty();
        $host = $env[$varNames['DB_HOST']];
        $database = $env[$varNames['DB_NAME']];
        $username = $env[$varNames['DB_USER']];
        $password = $env[$varNames['DB_PASS']];
        return component(static::class, [$type, $host, $database, $username, $password]);
    }

    /**
     * @param string $type
     * @param string $host
     * @param string $database
     * @param string $username
     * @param string $password
     */
    public function __construct(
        protected string $type,
        protected string $host,
        protected string $database,
        protected string $username,
        protected string $password
    ) {
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getDatabase(): string
    {
        return $this->database;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
