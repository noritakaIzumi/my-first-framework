<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/09
 * Time: 03:59
 */

use Core\Component\AbstractJob;
use Core\Factory\SharedFactory;
use Core\Shared\Routes;

$routes = SharedFactory::get(Routes::class);

// ここからルーティングを書く

$routes->get('/', [
    static function (): array {
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
