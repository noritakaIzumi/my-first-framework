<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/08
 * Time: 22:43
 */

namespace Application;

class Workflow
{
    public ?Job $head = null;
    public array $artifacts = [];
}
