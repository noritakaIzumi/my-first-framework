<?php

namespace Support\Factory;

class OverrideComponent extends PureComponent
{
    public function func(): string
    {
        return 'override component';
    }
}
