<?php

namespace Internal\Shared;

use Monolog\Handler\StreamHandler;
use Monolog\Level;

class Config
{
    protected AbstractPathConfig $paths;

    public function __construct()
    {
        $this->paths = paths();
    }

    /**
     * php.ini の設定を上書きする
     * @return $this
     */
    public function phpIni(): static
    {
        ini_set('display_errors', 0);
        ini_set('error_log', $this->paths->log . '/php_error.log');
        return $this;
    }

    /**
     * エラーハンドラの設定
     * @return $this
     */
    public function errorHandler(): static
    {
        set_error_handler([shared(ErrorHandling::class), 'handler']);
        return $this;
    }

    /**
     * ロギングの設定
     * @return $this
     */
    public function logging(): static
    {
        $logging = shared(Logging::class);
        $logging->addLogger('default');
        $logging
            ->getLogger('default')
            ->pushHandler(new StreamHandler($this->paths->log . '/default.log', Level::Debug));
        return $this;
    }

    /**
     * カスタム設定
     * @return $this
     */
    public function custom(): static
    {
        return $this;
    }
}
