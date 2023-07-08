<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/28
 * Time: 02:56
 */

namespace Internal;

use Internal\Shared\Config;

/**
 * Cmd 起動前の初期化処理
 */
class Initializer
{
    public function run(): void
    {
        // load util functions
        foreach (glob(__DIR__ . '/util/*.php') as $file) {
            require_once $file;
        }

        // load configs
        shared(Config::class)
            ->phpIni()
            ->errorHandler()
            ->logging()
            ->custom();

        // load routes
        $routesFilepath = paths()->config . '/routes.php';
        if (file_exists($routesFilepath)) {
            require_once $routesFilepath;
        }
    }
}
