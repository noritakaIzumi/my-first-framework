<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/11/21
 * Time: 18:20
 */

namespace Cmd;

use AbstractTestCase;
use Internal\Shared\HttpHeadersSent;
use Internal\Shared\Routes;

class WebCmdTest extends AbstractTestCase
{
    protected static WebCmd $registry;
    protected WebCmd $cmd;
    protected Routes $routes;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$registry = (new WebCmd('/index.php'))->setGetQueryFromUrl(true);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->cmd = clone self::$registry;
        $this->routes = routes();
        ob_start();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        ob_end_clean();
    }

    protected function assertOutput(string $output): void
    {
        $this->assertSame($output, ob_get_contents());
        ob_clean();
    }

    /**
     * 例えば "/hello" というパスに対して GET メソッドのルーティングを行う場合は
     * $routes->get('/hello', [callbacks]) のように記述します。
     *
     * @return void
     */
    public function test_基本ケース(): void
    {
        $this->routes->get(
            '/hello',
            [
                // このようにクロージャーを用意して処理を行います。
                // HTTP 経由のアクセスの場合は、アーティファクトの output に設定したものが画面に出力されます。
                // この場合は "Hello World." と出力されます。
                static function () {
                    artifact()->set('output', 'Hello World.');
                },
            ],
        );

        $this->cmd->run('get', '/hello');
        $this->assertOutput('Hello World.');
    }

    /**
     * クロージャーを複数指定した場合、前のクロージャーの返り値が次のクロージャーの第一引数に渡されます。
     *
     * @return void
     */
    public function test_クロージャーを複数指定したケース(): void
    {
        $this->routes->get(
            '/goodbye',
            [
                static function () {
                    // 次のクロージャに値を引き継ぎたい場合は artifacts インスタンスを取得してキーと値をセットします。
                    // ここでは planet というキーに "Mars" という値をセットします。
                    artifact()->set('planet', 'Mars');
                },
                // 前のクロージャーで artifacts にセットした値 "Mars" を受け取り "Goodbye Mars." と出力します。
                static function () {
                    $planet = artifact()->get('planet');

                    artifact()->set('output', "Goodbye $planet.");
                }
            ]
        );

        $this->cmd->run('get', '/goodbye');
        $this->assertOutput('Goodbye Mars.');
    }

    /**
     * URI はスラッシュで区切られ、以下のようにクロージャーの引数に渡されます。
     *
     * @return void
     */
    public function test_パターンにスラッシュが複数あるケース(): void
    {
        $this->routes->get(
            '/Jane/Doe',
            [
                // $firstName = "Jane", $lastName = "Doe" となります。
                static function (string $firstName = '', string $lastName = '') {
                    // It produces "I'm Jane Doe. Please call me Jane."
                    artifact()->set('output', "I'm $firstName $lastName. Please call me $firstName.");
                },
            ]
        );

        $this->cmd->run('get', '/Jane/Doe');
        $this->assertOutput("I'm Jane Doe. Please call me Jane.");
    }

    /**
     * URI パターンには正規表現を指定できます。
     *
     * @return void
     */
    public function test_正規表現を指定するケース1(): void
    {
        $this->routes
            ->get(
                '/[0-9]+',
                [
                    static function (string $id = '') {
                        artifact()->set('output', $id);
                    },
                ]
            );

        $this->cmd->run('get', '/123');
        $this->assertOutput('123');
    }

    public function test_正規表現を指定するケース2_引数を入れ替える(): void
    {
        $this->routes
            ->get(
                '/(\w+)/(morning|afternoon|evening)',
                [
                    static function (string $time = '', string $name = '') {
                        $name = ucfirst($name);
                        artifact()->set('output', "Good $time, $name.");
                    }
                ],
                /*
                 * 第三引数は preg_replace の第二引数のように扱うことができます。
                 * https://www.php.net/manual/en/function.preg-replace
                 */
                '$2/$1'
            );

        $this->cmd->run('get', '/jane/morning');
        $this->assertOutput('Good morning, Jane.');

        $this->cmd->run('get', '/noah/afternoon');
        $this->assertOutput('Good afternoon, Noah.');
    }

    /**
     * リクエストパラメータは Request クラスから受け取ります。
     *
     * @return void
     */
    public function test_リクエストパラメータ(): void
    {
        $this->routes->get(
            '/request',
            [
                // "/request?year=2022&month=8&day=16" でアクセスすると "2022/8/16" を返します。
                // "/request" のようにパラメータがない場合は、第二引数に指定された値があればそれを返します。
                static function () {
                    $request = request();

                    $year = $request->getGet('year', 'unknown');
                    $month = $request->getGet('month', 'unknown');
                    $day = $request->getGet('day', 'unknown');

                    artifact()->set('output', "$year/$month/$day");
                },
            ],
        );

        $this->cmd->run('get', '/request?year=2022&month=8&day=16');
        $this->assertOutput('2022/8/16');

        $this->cmd->run('get', '/request');
        $this->assertOutput('unknown/unknown/unknown');
    }

    public function test_ヘッダを送信する_何も送信しない(): void
    {
        $this->routes->get(
            '/hello',
            [
                static function () {
                },
            ]
        );

        $this->cmd->run('get', '/hello');
        $this->assertSame(
            [],
            shared(HttpHeadersSent::class)->getHeaders(),
            '送信されたヘッダ',
        );
    }

    /**
     * テスト上では実際に送信できないため、仮の確認となります。
     * @return void
     */
    public function test_ヘッダを送信する_コンテンツタイプを指定(): void
    {
        $this->routes->get(
            '/hello',
            [
                static function () {
                    // ヘッダは以下のようにセットします
                    httpHeader()->addHeader('Content-Type: application/json', responseCode: 200);
                },
            ]
        );

        $this->cmd->run('get', '/hello');
        $httpHeadersSent = shared(HttpHeadersSent::class);
        $this->assertSame(
            ['Content-Type' => ['application/json']],
            $httpHeadersSent->getHeaders(),
            '送信されたヘッダ',
        );
        $this->assertSame(200, $httpHeadersSent->getResponseCode());
    }

    public function test_ヘッダを送信する_同じnameを複数指定_上書きする(): void
    {
        $this->routes->get(
            '/hello',
            [
                static function () {
                    httpHeader()->addHeader('Content-Type: application/json');
                    httpHeader()->addHeader('Content-Type: text/plain');
                },
            ]
        );

        $this->cmd->run('get', '/hello');
        $this->assertSame(
            ['Content-Type' => ['text/plain']],
            shared(HttpHeadersSent::class)->getHeaders(),
            '送信されたヘッダ',
        );
    }

    public function test_ヘッダを送信する_同じnameを複数指定_上書きしない(): void
    {
        $this->routes->get(
            '/hello',
            [
                static function () {
                    httpHeader()->addHeader('Content-Type: application/json', false);
                    httpHeader()->addHeader('Content-Type: text/plain', false);
                },
            ]
        );

        $this->cmd->run('get', '/hello');
        $this->assertSame(
            ['Content-Type' => ['application/json', 'text/plain']],
            shared(HttpHeadersSent::class)->getHeaders(),
            '送信されたヘッダ',
        );
    }
}
