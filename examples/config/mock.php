<?php

use Internal\Factory\SharedFactory;
use Internal\PathConfig;
use Internal\Shared\AbstractPathConfig;

SharedFactory::overloadClass(AbstractPathConfig::class, PathConfig::class);
