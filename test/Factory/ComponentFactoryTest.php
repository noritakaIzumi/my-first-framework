<?php

namespace Factory;

use AbstractTestCase;
use Internal\Factory\ComponentFactory;
use Support\Factory\OverrideComponent;
use Support\Factory\PureComponent;

class ComponentFactoryTest extends AbstractTestCase
{
    public function testGetInstance__モックもクラスも登録しない場合、元のクラスがインスタンス化される()
    {
        $component = component(PureComponent::class);
        $this->assertSame('pure component', $component->func());
    }

    public function testGetInstance__モックのみを登録した場合、そのモックが返される()
    {
        $mockComponent = new class extends PureComponent {
            public function func(): string
            {
                return 'mock component';
            }
        };
        ComponentFactory::injectMock(PureComponent::class, $mockComponent);
        $component = component(PureComponent::class);
        $this->assertSame('mock component', $component->func());
    }

    public function testGetInstance__クラスのみを登録した場合、そのクラスのインスタンスが返される()
    {
        ComponentFactory::overrideClass(PureComponent::class, OverrideComponent::class);
        $component = component(PureComponent::class);
        $this->assertSame('override component', $component->func());
    }
}
