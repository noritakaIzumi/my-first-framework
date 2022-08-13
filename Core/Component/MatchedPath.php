<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/14
 * Time: 06:52
 */

namespace Core\Component;

class MatchedPath
{
    /**
     * @var array|callable[]
     */
    public array $callbacks;
    /**
     * @var array
     */
    public array $firstArguments;

    /**
     * @param array|callable[] $callbacks
     * @param array            $first_arguments
     */
    public function __construct(array $callbacks, array $first_arguments)
    {
        $this->callbacks = $callbacks;
        $this->firstArguments = $first_arguments;
    }
}
