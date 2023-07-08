<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/11/21
 * Time: 18:59
 */

use Internal\Factory\FactoryManager;

require_once __DIR__ . '/Support/config/autoload.php';

// mark as testing environment
const IS_TESTING = true;

// Display errors in test
ini_set('display_errors', 1);

// save mock state
shared(FactoryManager::class)->save();
