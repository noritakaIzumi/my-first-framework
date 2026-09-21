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
$routes = routes();

// ここからルーティングを書く

$routes->get(
    '/hello',
    [
        static function () {
            artifact()->set('output', 'Hello World.');
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

            artifact()->set('output', 'log output');
        },
    ],
);
