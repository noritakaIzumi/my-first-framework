<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/09/03
 * Time: 10:16
 */

namespace Cmd;

abstract class AbstractCmd
{
    public function __construct()
    {
        $this->init();
    }

    protected function init(): void
    {
        set_error_handler('myErrorHandler');
    }
}
