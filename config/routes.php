<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/09
 * Time: 03:59
 */

use Core\AbstractJob;
use Core\Routes;
use Core\SharedServices;

$routes = SharedServices::get(Routes::class);

// ここからルーティングを書く

$routes->get('/', [
    static function (): array {
        // echo 'process 1<br>';

        return ['foo' => 'bar'];
    },
    static function (array $artifacts) {
        return ['apple' => 100];
    },
    new class extends AbstractJob {
        public function execute(array $artifacts): array
        {
            $artifacts['banana'] = 200;

            return $artifacts;
        }
    },
]);

// ここまで
