<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/09
 * Time: 03:57
 */

namespace Core\Shared;

use Core\Component\Route;
use Core\Factory\ComponentFactory;

class Routes
{
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
     * @param string $pattern
     * @param array  $callbacks
     * @param string $replacement 引数
     *
     * @return $this
     */
    public function get(string $pattern, array $callbacks, string $replacement = ''): static
    {
        $this->get[$pattern] = ComponentFactory::getInstance(
            Route::class,
            [$pattern, $callbacks, $replacement],
        );

        return $this;
    }
}
