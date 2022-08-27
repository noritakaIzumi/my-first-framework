<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/28
 * Time: 03:39
 */

namespace Internal\Shared;

use Internal\Factory\ComponentFactory;
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
        $this->loggers[$name] = ComponentFactory::getInstance(Logger::class, [$name]);

        return $this;
    }

    public function getLogger(string $name): Logger
    {
        return $this->loggers[$name];
    }
}
