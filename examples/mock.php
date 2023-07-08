<?php

use Internal\Factory\SharedFactory;
use Internal\Shared\AbstractPathConfig;
use Mock\PathConfig;

SharedFactory::overloadClass(AbstractPathConfig::class, PathConfig::class);
