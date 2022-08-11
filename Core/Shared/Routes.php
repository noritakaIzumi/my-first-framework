<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/09
 * Time: 03:57
 */

namespace Core\Shared;

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
     * @todo 正規表現の replacement = $n 等の対応
     */
    public function get(string $pattern, array $callbacks): static
    {
        $this->get[$pattern] = $callbacks;

        return $this;
    }
}
