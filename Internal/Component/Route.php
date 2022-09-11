<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/14
 * Time: 06:39
 */

namespace Internal\Component;

class Route extends BaseComponent
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
        parent::__construct();
        $this->pattern = $pattern;
        $this->callbacks = $callbacks;
        $this->replacement = $replacement;
    }
}
