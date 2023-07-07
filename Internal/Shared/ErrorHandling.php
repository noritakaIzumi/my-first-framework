<?php

namespace Internal\Shared;

class ErrorHandling
{
    public function handler(
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

        $errLevelStr = preg_match('/^E[A-Z_]*_([A-Z]+)$/', $this->friendlyErrorType($errno), $matches) ? $matches[1] : '';
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

    /**
     * @link https://www.php.net/manual/en/errorfunc.constants.php#109430
     *
     * @param int $type
     *
     * @return string
     */
    protected function friendlyErrorType(int $type): string
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
