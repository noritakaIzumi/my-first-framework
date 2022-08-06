<?php

use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/07
 * Time: 06:36
 */
class AbstractTestCase extends TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }
}
