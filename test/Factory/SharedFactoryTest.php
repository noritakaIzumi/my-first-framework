<?php

namespace Factory;

use AbstractTestCase;
use Internal\Factory\SharedFactory;
use Support\Factory\OverrideComponent;
use Support\Factory\PureComponent;

class SharedFactoryTest extends AbstractTestCase
{
    public function testGetInstance__モックもクラスも登録しない場合、元のクラスがインスタンス化される()
    {
        $obj = shared(PureComponent::class);
        $this->assertSame('pure component', $obj->func());
    }

    public function testGetInstance__2度呼び出した場合、返されるインスタンスは同一のものである()
    {
        $obj1 = shared(PureComponent::class);
        $obj2 = shared(PureComponent::class);
        $this->assertSame('pure component', $obj1->func());
        $this->assertSame('pure component', $obj2->func());
        $this->assertTrue(spl_object_hash($obj1) === spl_object_hash($obj2));
    }

    public function testGetInstance__モックのみを登録して1度呼び出した場合、登録したモックと同じものが返される()
    {
        $mockObj = new class extends PureComponent {
            public function func(): string
            {
                return 'mock component';
            }
        };
        SharedFactory::injectMock(PureComponent::class, $mockObj);
        $obj = shared(PureComponent::class);
        $this->assertSame('mock component', $obj->func());
        $this->assertSame(spl_object_hash($mockObj), spl_object_hash($obj));
    }

    public function testGetInstance__クラスのみを登録して1度呼び出した場合、そのクラスのインスタンスが返される()
    {
        SharedFactory::overrideClass(PureComponent::class, OverrideComponent::class);
        $obj = shared(PureComponent::class);
        $this->assertSame('override component', $obj->func());
    }

    public function testGetInstance__クラスのみを登録して2度呼び出した場合、返されるインスタンスは同一のものである()
    {
        SharedFactory::overrideClass(PureComponent::class, OverrideComponent::class);
        $obj1 = shared(PureComponent::class);
        $obj2 = shared(PureComponent::class);
        $this->assertSame('override component', $obj1->func());
        $this->assertSame('override component', $obj2->func());
        $this->assertTrue(spl_object_hash($obj1) === spl_object_hash($obj2));
    }
}
