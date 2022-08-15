<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/14
 * Time: 03:33
 */

namespace Internal\Shared\Response;

interface ResponseInterface
{
    public function output(mixed $artifacts): void;
}
