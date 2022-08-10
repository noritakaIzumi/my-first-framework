<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/09
 * Time: 03:59
 */

use Core\Factory;
use Core\Routes;
use Core\SampleService;

$routes = Factory::get(Routes::class);

// ここからルーティングを書く

$routes->get('/', [
    static function (): array {
        // echo 'process 1<br>';

        return ['foo' => 'bar'];
    },
    static function (array $artifacts) {
        // echo 'process 2<br>';
        $artifacts['blah'] = 'blah';

        return 123;
    },
]);

// ここまで

Factory::register(Routes::class, $routes);
