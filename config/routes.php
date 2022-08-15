<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/09
 * Time: 03:59
 */

/*
 * ルーティング
 */

use Core\Factory\SharedFactory;
use Core\Shared\Routes;

$routes = SharedFactory::getInstance(Routes::class);

// ここからルーティングを書く

/*
 * 例えば /hello というパスに対して GET メソッドのルーティングを行う場合は
 * $routes->get('/hello', [callbacks]) のように記述します。
 */
$routes->get(
    '/hello',
    [
        // このようにクロージャーを用意して関数の返り値に指定すると、画面には "hello world" と表示されます。
        static function () {
            return 'Hello World.';
        },
    ],
);

/*
 * クロージャーを複数指定した場合、前のクロージャーの返り値が次のクロージャーの第一引数に渡されます。
 */
$routes->get(
    '/goodbye',
    [
        static function () {
            return 'Mars';
        },
        // 前のクロージャーで出力した "Mars" を $artifacts で受け取り "Goodbye Mars." と出力します。
        static function ($artifacts) {
            return "Goodbye $artifacts.";
        }
    ]
);

/*
 * URI はスラッシュで区切られ、以下のようにクロージャーの引数に渡されます。
 */
$routes->get(
    '/Jane/Doe',
    [
        // $firstName = "Jane", $lastName = "Doe" となります。
        static function (string $firstName = '', string $lastName = '') {
            // It produces "I'm Jane Doe. Please call me Jane."
            return "I'm $firstName $lastName. Please call me $firstName.";
        },
    ]
);
