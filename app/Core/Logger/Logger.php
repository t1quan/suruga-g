<?php

namespace App\Core\Logger;

use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Class Logger
 */
class Logger {

    static private $traceLoggerNm = 'trace';
    static private $sqlLoggerNm = 'sql';
    static private $throwableLoggerNm = 'throwable';

    /**
     * @param  $message
     * @param $object
     */
    public static function debugTrace($message, $object = null) {
        if($object === null){
            Log::channel(self::$traceLoggerNm)->debug($message);
        }else{
            Log::channel(self::$traceLoggerNm)->debug($message, [$object]);
        }
    }

    /**
     * @param  $sql
     */
    public static function debugSqlQuery($sql) {
        Log::channel(self::$sqlLoggerNm)->debug($sql);
    }

    /**
     * @param string $message
     * @param Exception|null $throwable
     */
    public static function debugThrowable($message, Exception $throwable = null) {
        Log::channel(self::$throwableLoggerNm)->debug($message, [$throwable]);
    }

    /**
     * @param  $message
     * @param $object
     */
    public static function infoTrace($message, $object = null) {
        if($object === null){
            Log::channel(self::$traceLoggerNm)->info($message);
        }else{
            Log::channel(self::$traceLoggerNm)->info($message, [$object]);
        }
    }

    /**
     * @param  $sql
     */
    public static function infoSqlQuery($sql) {
        Log::channel(self::$sqlLoggerNm)->info($sql);
    }

    /**
     * @param string $message
     * @param Exception|null $throwable
     */
    public static function infoThrowable($message, Exception $throwable = null) {
        Log::channel(self::$throwableLoggerNm)->info($message, [$throwable]);
    }

    /**
     * @param $message
     * @param  $object
     */
    public static function warnTrace($message, $object) {
        Log::channel(self::$traceLoggerNm)->warn($message, [$object]);
    }

    /**
     * @param  $sql
     */
    public static function warnSqlQuery($sql) {
        Log::channel(self::$sqlLoggerNm)->warn($sql);
    }

    /**
     * @param string $message
     * @param Exception|null $throwable
     */
    public static function warnThrowable($message, Exception $throwable = null) {
        Log::channel(self::$throwableLoggerNm)->warn($message, [$throwable]);
    }

    /**
     * @param $message
     * @param  $object
     */
    public static function errorTrace($message, $object) {
        Log::channel(self::$traceLoggerNm)->error($message, [$object]);
    }

    /**
     * @param  $sql
     */
    public static function errorSqlQuery($sql) {
        Log::channel(self::$sqlLoggerNm)->error($sql);
    }

    /**
     * @param string $message
     * @param Exception|null $throwable
     */
    public static function errorThrowable($message, Exception $throwable = null) {
        Log::channel(self::$throwableLoggerNm)->error($message, [$throwable]);
    }

    /**
     * @param  $message
     * @param $object
     */
    public static function fatalTrace($message, $object) {
        Log::channel(self::$traceLoggerNm)->fatal($message, [$object]);
    }

    /**
     * @param  $sql
     */
    public static function fatalSqlQuery($sql) {
        Log::channel(self::$sqlLoggerNm)->fatal($sql);
    }

    /**
     * @param string $message
     * @param Exception|null $throwable
     */
    public static function fatalThrowable($message, Exception $throwable = null) {
        Log::channel(self::$throwableLoggerNm)->fatal($message, [$throwable]);
    }

    private static function addThrowableInfomation($message, Exception $throwable = null) {
        if ($throwable !== null) {
            $message .= PHP_EOL . ' throwable : ' . $throwable->getMessage() . PHP_EOL . PHP_EOL . $throwable->getTraceAsString();
        }
        return $message;
    }

}
