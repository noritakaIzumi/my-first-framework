<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/11/21
 * Time: 18:59
 */

use Internal\Factory\FactoryManager;

require_once __DIR__ . '/../examples/autoload.php';

// Display errors in test
ini_set('display_errors', 1);

// save mock state
shared(FactoryManager::class)->save();
