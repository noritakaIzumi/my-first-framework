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

use Internal\Factory\SharedFactory;
use Internal\Shared\Routes;
use Internal\Shared\Store\Request;

$routes = SharedFactory::getInstance(Routes::class);

// ここからルーティングを書く

/*
 * 例えば "/hello" というパスに対して GET メソッドのルーティングを行う場合は
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
            // 次のクロージャに値を引き継ぎたい場合は artifacts インスタンスを取得してキーと値をセットします。
            // ここでは planet というキーに "Mars" という値をセットします。
            artifacts()->set('planet', 'Mars');
        },
        // 前のクロージャーで artifacts にセットした値 "Mars" を受け取り "Goodbye Mars." と出力します。
        static function () {
            $planet = artifacts()->get('planet');

            return "Goodbye $planet.";
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

/*
 * URI パターンには正規表現を指定できます。
 */
$routes
    ->get(
        '/[0-9]+',
        [
            static function (string $id = '') {
                // access to "/123", and returns "123".
                return $id;
            },
        ]
    )
    // しれっと書きましたが、メソッドチェーンが使えます。
    ->get(
        '/(\w+)/(morning|afternoon|evening)',
        [
            static function (string $time = '', string $name = '') {
                $name = ucfirst($name);

                // access to "/jane/morning", and returns "Good morning, Jane."
                // access to "/noah/evening", and returns "Good evening, Noah."
                return "Good $time, $name.";
            }
        ],
        // 第三引数は preg_replace の第二引数のように扱うことができます。
        '$2/$1'
    );

/*
 * リクエストパラメータは Request クラスから受け取ります。
 */
$routes->get(
    '/request',
    [
        // "/request?year=2022&month=8&day=16" でアクセスすると "2022/8/16" を返します。
        // "/request" のようにパラメータがない場合は、第二引数に指定された値があればそれを返します。
        static function () {
            $request = SharedFactory::getInstance(Request::class);

            $year = $request->get('year', 'unknown');
            $month = $request->get('month', 'unknown');
            $day = $request->get('day', 'unknown');

            return "$year/$month/$day";
        },
    ],
);

/*
 * データベースに接続したりログに出力したりするには以下のようにします。
 */
$routes->get(
    '/log',
    [
        static function () {
            /*
             * connectDatabase 関数でデータベースへのコネクションを取得します。
             * コネクションはこの関数が終了後、自動的に切断されます。
             */
            $db = connectDatabase();
            /*
             * logger 関数でロガーオブジェクトを取得します。
             * デフォルトでは Monolog を使用しています。詳しくはこちらをご覧ください。
             * https://github.com/Seldaek/monolog
             */
            logger()->info(json_encode($db->info(), JSON_THROW_ON_ERROR));

            return 'log output';
        },
    ],
);
