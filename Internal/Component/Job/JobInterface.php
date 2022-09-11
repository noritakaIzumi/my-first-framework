<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/09/11
 * Time: 17:58
 */

namespace Internal\Component\Job;

interface JobInterface
{
    public function setScript(?callable $func): self;
    public function execute($artifacts, ...$args);
}
