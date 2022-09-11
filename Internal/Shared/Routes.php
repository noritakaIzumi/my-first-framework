<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/09
 * Time: 03:57
 */

namespace Internal\Shared;

use Internal\Component\Route;

class Routes
{
    protected static array $allowedMethods = [
        'get',
        'post',
    ];

    /**
     * GET パラメータ。
     *
     * @var Route[]
     */
    public array $get = [];
    /**
     * POST パラメータ。
     *
     * @var Route[]
     */
    public array $post = [];

    /**
     * @param string $method
     * @param string $pattern
     * @param array  $callbacks
     * @param string $replacement
     *
     * @return $this
     */
    protected function add(string $method, string $pattern, array $callbacks, string $replacement): static
    {
        if (in_array($method, self::$allowedMethods, true)) {
            $this->{$method}[$pattern] = component(
                Route::class,
                [$pattern, $callbacks, $replacement],
            );
        }

        return $this;
    }

    public function get(string $pattern, array $callbacks, string $replacement = ''): static
    {
        return $this->add('get', $pattern, $callbacks, $replacement);
    }

    public function post(string $pattern, array $callbacks, string $replacement = ''): static
    {
        return $this->add('post', $pattern, $callbacks, $replacement);
    }
}
