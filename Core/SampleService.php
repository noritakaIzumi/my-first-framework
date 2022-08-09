<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/09
 * Time: 05:40
 */

namespace Core;

class SampleService
{
    public function test(): array
    {
        $a = func_get_args();
        return ['apple' => 100];
    }
}
