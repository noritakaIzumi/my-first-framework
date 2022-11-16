<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/09
 * Time: 03:57
 */

namespace Internal\Shared;

use Internal\Component\Route;

/**
 * ルーティングクラス。
 *
 * @method $this get(string $pattern, array $callbacks, string $replacement = '') GET メソッドのパターンを追加します。
 * @method $this post(string $pattern, array $callbacks, string $replacement = '') POST メソッドのパターンを追加します。
 */
class Routes
{
    protected static array $allowedMethods = [
        'get',
        'post',
    ];

    protected array $get = [];
    protected array $post = [];

    /**
     * @return array
     */
    public function getGet(): array
    {
        return $this->get;
    }

    /**
     * @return array
     */
    public function getPost(): array
    {
        return $this->post;
    }

    /**
     * ルーティングにパターンを追加します。
     *
     * @param string $method      メソッド名。
     * @param string $pattern     URL パターン。
     * @param array  $callbacks   処理。
     * @param string $replacement URL と引数の置き換えパターン。
     *
     * @return $this
     */
    protected function add(string $method, string $pattern, array $callbacks, string $replacement = ''): static
    {
        $this->{$method} ??= [];

        $this->{$method}[$pattern] = component(
            Route::class,
            [$pattern, $callbacks, $replacement],
        );

        return $this;
    }

    /**
     * @param string $method リクエストメソッド
     * @param array  $arguments
     *
     * @return $this
     */
    public function __call(string $method, array $arguments)
    {
        if (in_array($method, self::$allowedMethods, true)) {
            $this->add($method, ...$arguments);

            return $this;
        }

        trigger_error("method $method is not allowed or supported.", E_USER_ERROR);
    }
}
