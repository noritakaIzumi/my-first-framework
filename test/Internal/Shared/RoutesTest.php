<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/11/16
 * Time: 16:29
 */

namespace Internal\Shared;

use AbstractTestCase;
use Closure;

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

    /**
     * assert by hash of the closure
     *
     * @param Closure $expectedClosure
     * @param string  $method
     * @param string  $pattern
     * @param int     $index
     *
     * @return void
     */
    protected function assertCallback(Closure $expectedClosure, string $method, string $pattern, int $index): void
    {
        $callbacks = match ($method) {
            'get' => $this->routes->getGet(),
            'post' => $this->routes->getPost(),
            default => $this->fail("$method is invalid"),
        };

        $this->assertSame(
            spl_object_id($expectedClosure),
            spl_object_id($callbacks[$pattern]->getCallbacks()[$index]),
        );
    }

    public function test_getメソッドに追加(): void
    {
        $closure = static fn() => null;

        $this->routes->get('/', [$closure]);

        $this->assertCallback($closure, 'get', '/', 0);
    }

    public function test_postメソッドに追加(): void
    {
        $closure = static fn() => null;

        $this->routes->post('/', [$closure]);

        $this->assertCallback($closure, 'post', '/', 0);
    }

    public function test_同じパターンを同じメソッドに複数回追加すると上書きされる(): void
    {
        $closure1 = static fn() => null;
        $closure2 = static fn() => null;

        $this->routes->get('/', [$closure1]);
        $this->routes->get('/', [$closure2]);

        $this->assertCallback($closure2, 'get', '/', 0);
    }
}
