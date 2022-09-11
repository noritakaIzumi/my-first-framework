<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/09/03
 * Time: 09:50
 */

use Internal\Component\Database\Dbh;
use Internal\Component\Job\Job;
use Internal\Component\Job\JobInterface;
use Internal\Factory\ComponentFactory;
use Internal\Factory\SharedFactory;
use Internal\Shared\Artifacts;
use Internal\Shared\Database\Database;
use Internal\Shared\Logging;
use Monolog\Logger;

/*
 * job execution
 */

if (!function_exists('jobCreate')) {
    /**
     * @template _T
     *
     * @param class-string<_T> $jobClass
     *
     * @return _T
     */
    function jobCreate(string $jobClass = Job::class): JobInterface
    {
        if (!class_exists($jobClass)) {
            trigger_error("class $jobClass not exists", E_USER_ERROR);
        }

        $implements = class_implements($jobClass);
        if (!isset($implements[JobInterface::class])) {
            trigger_error("class $jobClass does not implement JobInterface", E_USER_ERROR);
        }

        /** @var JobInterface $job */
        $job = ComponentFactory::getInstance($jobClass);

        return $job;
    }
}

if (!function_exists('artifacts')) {
    /**
     * アーティファクトを取得します。
     *
     * @return Artifacts
     */
    function artifacts(): Artifacts
    {
        return SharedFactory::getInstance(Artifacts::class);
    }
}

/*
 * database
 */

if (!function_exists('connectDatabase')) {
    /**
     * データベースへ接続します。
     *
     * @return Dbh
     */
    function connectDatabase(): Dbh
    {
        $database = SharedFactory::getInstance(Database::class);
        $database->connect();

        return $database->connection->dbh;
    }
}

/*
 * log
 */

if (!function_exists('logger')) {
    /**
     * logger を取得します。
     *
     * @param string $name
     *
     * @return Logger
     */
    function logger(string $name = 'default'): Logger
    {
        return SharedFactory::getInstance(Logging::class)->getLogger($name);
    }
}

/*
 * handling errors
 */

if (!function_exists('FriendlyErrorType')) {
    /**
     * @link https://www.php.net/manual/en/errorfunc.constants.php#109430
     *
     * @param int $type
     *
     * @return string
     */
    function FriendlyErrorType(int $type): string
    {
        return match ($type) {
            E_ERROR => 'E_ERROR',
            E_WARNING => 'E_WARNING',
            E_PARSE => 'E_PARSE',
            E_NOTICE => 'E_NOTICE',
            E_CORE_ERROR => 'E_CORE_ERROR',
            E_CORE_WARNING => 'E_CORE_WARNING',
            E_COMPILE_ERROR => 'E_COMPILE_ERROR',
            E_COMPILE_WARNING => 'E_COMPILE_WARNING',
            E_USER_ERROR => 'E_USER_ERROR',
            E_USER_WARNING => 'E_USER_WARNING',
            E_USER_NOTICE => 'E_USER_NOTICE',
            E_STRICT => 'E_STRICT',
            E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
            E_DEPRECATED => 'E_DEPRECATED',
            E_USER_DEPRECATED => 'E_USER_DEPRECATED',
            default => '',
        };
    }
}

if (!function_exists('myErrorHandler')) {
    function myErrorHandler(
        int $errno,
        string $errstr,
        string $errfile = '',
        int $errline = 0,
    ): bool {
        if (!(error_reporting() & $errno)) {
            return false;
        }

        $errstr = htmlspecialchars($errstr);
        $errfile = preg_replace('#^' . realpath(APP_PATH) . '#', 'APP_PATH', $errfile);
        $errfile = preg_replace('#^' . realpath(SYSTEM_PATH) . '#', 'SYSTEM_PATH', $errfile);

        $errLevelStr = preg_match('/^E[A-Z_]*_([A-Z]+)$/', FriendlyErrorType($errno), $matches) ? $matches[1] : '';
        $logger = logger();
        $logStr = "($errfile:$errline) $errstr";
        switch ($errLevelStr) {
            case 'ERROR':
                $logger->error($logStr);
                break;
            case 'WARNING':
                $logger->warning($logStr);
                break;
            case 'NOTICE':
                $logger->notice($logStr);
                break;
            case 'PARSE':
            case 'STRICT':
            case 'DEPRECATED':
                $logger->info($logStr);
                break;
            default:
                $logger->debug($logStr);
        }

        return true;
    }
}
