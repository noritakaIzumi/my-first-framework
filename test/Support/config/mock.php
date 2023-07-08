<?php

use Internal\Factory\SharedFactory;
use Internal\Shared\AbstractPathConfig;
use Support\Internal\PathConfig;

SharedFactory::overloadClass(AbstractPathConfig::class, PathConfig::class);
