<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/28
 * Time: 03:39
 */

namespace Internal\Shared;

use Monolog\Logger;

class Logging
{
    /**
     * @var Logger[]
     */
    protected array $loggers = [];

    public function __construct()
    {
    }

    public function addLogger(string $name): static
    {
        $this->loggers[$name] = component(Logger::class, [$name]);

        return $this;
    }

    public function getLogger(string $name): Logger
    {
        if (!isset($this->loggers[$name])) {
            $this->addLogger($name);
        }

        return $this->loggers[$name];
    }
}
