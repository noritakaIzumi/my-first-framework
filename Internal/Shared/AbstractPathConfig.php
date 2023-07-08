<?php

namespace Internal\Shared;

use RuntimeException;

/**
 * @property string $root リポジトリのルートディレクトリ
 * @property string $app アプリケーションディレクトリ
 * @property string $config コンフィグディレクトリ
 * @property string $log ログディレクトリ
 */
abstract class AbstractPathConfig
{
    public function __get(string $name)
    {
        $method = "_$name";
        if (method_exists($this, $method)) {
            return $this->$method();
        }

        throw new RuntimeException("the path \"$name\" does not exist");
    }

    public function __set(string $name, $value): void
    {
        throw new RuntimeException("cannot directly set paths");
    }

    public function __isset(string $name): bool
    {
        return isset($this->{$name});
    }

    /**
     * リポジトリのルートディレクトリ
     * @return non-empty-string
     * @noinspection PhpUnused
     */
    abstract protected function _root(): string;

    /**
     * アプリケーションディレクトリ
     * @return non-empty-string
     * @noinspection PhpUnused
     */
    abstract protected function _app(): string;

    /**
     * コンフィグディレクトリ
     * @return non-empty-string
     * @noinspection PhpUnused
     */
    abstract protected function _config(): string;

    /**
     * ログディレクトリ
     * @return non-empty-string
     * @noinspection PhpUnused
     */
    abstract protected function _log(): string;
}
