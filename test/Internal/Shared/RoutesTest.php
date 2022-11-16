<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/11/16
 * Time: 16:29
 */

namespace Internal\Shared;

use AbstractTestCase;

/**
 * @property Routes $routes
 */
class RoutesTest extends AbstractTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->routes = routes();
    }

    public function test_getメソッドに追加(): void
    {
        $closure = static fn() => null;

        $this->routes->get('/', [$closure]);

        // assert by hash of the closure
        $this->assertSame(
            spl_object_id($closure),
            spl_object_id($this->routes->get['/']->getCallbacks()[0]),
        );
    }

    public function test_postメソッドに追加(): void
    {
        $closure = static fn() => null;

        $this->routes->post('/', [$closure]);

        $this->assertSame(
            spl_object_id($closure),
            spl_object_id($this->routes->post['/']->getCallbacks()[0]),
        );
    }

    public function test_同じパターンを同じメソッドに複数回追加すると上書きされる(): void
    {
        $closure1 = static fn() => null;
        $closure2 = static fn() => null;

        $this->routes->get('/', [$closure1]);
        $this->routes->get('/', [$closure2]);

        $this->assertSame(
            spl_object_id($closure2),
            spl_object_id($this->routes->get['/']->getCallbacks()[0]),
        );
    }
}
