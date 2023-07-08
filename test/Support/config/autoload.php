<?php

use Internal\Initializer;

require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
require_once __DIR__ . '/mock.php';

/*
 * load files
 */
shared(Initializer::class)->run();
