<?php

namespace Support\Factory;

class OverloadComponent extends PureComponent
{
    public function func(): string
    {
        return 'overload component';
    }
}
