<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/14
 * Time: 06:39
 */

namespace Core\Component;

class Route
{
    public string $pattern;
    public array $callbacks;
    public string $replacement;

    /**
     * @param string $pattern
     * @param array  $callbacks
     * @param string $replacement
     */
    public function __construct(string $pattern, array $callbacks, string $replacement)
    {
        $this->pattern = $pattern;
        $this->callbacks = $callbacks;
        $this->replacement = $replacement;
    }
}
