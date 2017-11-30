<?php

/**
 * Set my custom error handler for this script
 */
set_error_handler('MyErrorHandler::errorLogger');

class MyErrorHandler
{

    public static function logger($e = null, $fileName)
    {
        self::exceptionLogger($e, $fileName, $logExt = 'logger_');
    }

    public static function exceptionLogger($e = null, $fileName, $logExt = 'exception_log_')
    {
        if (!is_null($e)) {
            if ($e instanceof Exception) {
                $log = "File: " . $fileName . ", Error code: {$e->getCode()}, Message: {$e->getMessage()}\n";
                file_put_contents('err_logs/log_' . date("j.n.Y") . '.txt', $log, FILE_APPEND);
            }

            if (is_string($e)) {
                $log = "File: " . $fileName . ", Type: {$e}\n";
                file_put_contents('err_logs/' . $logExt . date("j.n.Y") . '.txt', $log, FILE_APPEND);
            }
        }
    }

    public static function errorLogger($errno, $errstr, $errfile, $errline)
    {
        if (!(error_reporting() & $errno)) {
            // This error code is not included in error_reporting, so let it fall
            // through to the standard PHP error handler
            return false;
        }

        $phpVersion = PHP_VERSION;
        $phpOs = PHP_OS;
        $date = date("l jS \of F Y h:i:s A");

        switch ($errno) {
            case E_USER_ERROR:
                $log = <<<LOG
                /******** E_USER_ERROR **********/\n
                File: {$errfile}\n
                Errno: {$errno}\n
                Error message: {$errstr}\n
                Line where error occured: {$errline} \n
                PHP Version: {$phpVersion}\n
                PHP OS: {$phpOs}\n
                Time when error occured: {$date}\n
                -----------------------------------\n
                -----------------------------------\n
                \n
LOG;
                var_dump($log);
                file_put_contents('err_logs/php_internal_log_' . date("j.n.Y") . '.txt', $log, FILE_APPEND);
                exit(1);
                break;
            case E_USER_WARNING:
                $log = <<<LOG
                /******** E_USER_WARNING **********/\n
                File: {$errfile}\n
                Errno: {$errno}\n
                Error message: {$errstr}\n
                Line where error occured: {$errline} \n
                PHP Version: {$phpVersion}\n
                PHP OS: {$phpOs}\n
                Time when error occured: {$date}\n
                -----------------------------------\n
                -----------------------------------\n
                \n
LOG;
                break;

            case E_USER_NOTICE:
                $log = <<<LOG
                /******** E_USER_NOTICE **********/\n
                File: {$errfile}\n
                Errno: {$errno}\n
                Error message: {$errstr}\n
                Line where error occured: {$errline} \n
                PHP Version: {$phpVersion}\n
                PHP OS: {$phpOs}\n
                Time when error occured: {$date}\n
                -----------------------------------\n
                -----------------------------------\n
                \n
LOG;
                break;

            default:
                $log = <<<LOG
                /******** UNKNOWN ERROR **********/\n
                File: {$errfile}\n
                Errno: {$errno}\n
                Error message: {$errstr}\n
                Line where error occured: {$errline} \n
                PHP Version: {$phpVersion}\n
                PHP OS: {$phpOs}\n
                Time when error occured: {$date}\n
                -----------------------------------\n
                -----------------------------------\n
                \n
LOG;
                break;
        }
        var_dump($log);
        file_put_contents('err_logs/php_internal_log_' . date("j.n.Y") . '.txt', $log, FILE_APPEND);
        /* Don't execute PHP internal error handler */
        return true;
    }


}