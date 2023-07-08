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
    /**
     * driver. default to mysql.
     *
     * @var string
     */
    protected string $type = 'mysql';
    protected string $host;
    protected string $database;
    protected string $username;
    protected string $password;

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

    public function setFromEnv(string $profile = 'default'): ConnectionInfo
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
        if (array_key_exists($varNames['DB_TYPE'], $env)) {
            $this->type = $env[$varNames['DB_TYPE']];
        }

        $dotenv->required([
            $varNames['DB_HOST'],
            $varNames['DB_NAME'],
            $varNames['DB_USER'],
            $varNames['DB_PASS']
        ])->notEmpty();
        $this->host = $env[$varNames['DB_HOST']];
        $this->database = $env[$varNames['DB_NAME']];
        $this->username = $env[$varNames['DB_USER']];
        $this->password = $env[$varNames['DB_PASS']];

        return $this;
    }
}
