<?php

namespace Factory;

use AbstractTestCase;
use Internal\Factory\ComponentFactory;
use Support\Factory\OverloadComponent;
use Support\Factory\PureComponent;

class ComponentFactoryTest extends AbstractTestCase
{
    public function testGetInstance__モックもクラスも登録しない場合、元のクラスがインスタンス化される(): void
    {
        $component = component(PureComponent::class);
        $this->assertSame('pure component', $component->func());
    }

    public function testGetInstance__モックのみを登録した場合、そのモックが返される(): void
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

    public function testGetInstance__クラスのみを登録した場合、そのクラスのインスタンスが返される(): void
    {
        ComponentFactory::overloadClass(PureComponent::class, OverloadComponent::class);
        $component = component(PureComponent::class);
        $this->assertSame('overload component', $component->func());
    }
}
