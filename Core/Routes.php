<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/09
 * Time: 03:57
 */

namespace Core;

class Routes
{
    /**
     * @var array<string, callable[]|array>
     */
    public array $get = [];
    public array $post = [];

    /**
     * @param string $pattern
     * @param array  $callbacks
     *
     * @return $this
     */
    public function get(string $pattern, array $callbacks): static
    {
        $this->get[$pattern] = $callbacks;

        return $this;
    }
}
