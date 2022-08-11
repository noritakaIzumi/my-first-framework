<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/07
 * Time: 04:56
 */

namespace Core;

use AbstractTestCase;
use Core\Component\UrlComponents;

/**
 * @covers \Core\Component\UrlComponents
 */
class UrlComponentsTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testTest(): void
    {
        $urlComponents = new UrlComponents('path', 'query', 'fragment');
        $this->assertSame('path', $urlComponents->getPath());
        $this->assertSame('query', $urlComponents->getQuery());
        $this->assertSame('fragment', $urlComponents->getFragment());
    }
}
