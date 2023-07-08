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

    public function setFromEnv(): ConnectionInfo
    {
        $dotenv = Dotenv::createMutable(paths()->app, '.env.database');
        $env = $dotenv->load();

        $dotenv->ifPresent('DB_TYPE')->notEmpty();
        if (array_key_exists('DB_TYPE', $env)) {
            $this->type = $env['DB_TYPE'];
        }

        $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'])->notEmpty();
        $this->host = $env['DB_HOST'];
        $this->database = $env['DB_NAME'];
        $this->username = $env['DB_USER'];
        $this->password = $env['DB_PASS'];

        return $this;
    }
}
