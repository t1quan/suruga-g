<?php

namespace App\Core\Context;

use Closure;

class Context
{

    private static $requestTime;
    private static $userId;
    private static $loginId;
    private static $logger;
    private static $userNo;
    private static $programId;

    /**
     * @return mixed
     */
    public static function getStartTime()
    {
        return self::$requestTime;
    }

    /**
     * @return mixed
     */
    public static function getUserId()
    {
        return self::$userId;
    }

    /**
     * @var string $userId
     */
    public static function setUserId($userId)
    {
        self::$userId = $userId;
    }

    /**
     * @return mixed
     */
    public static function getShortUserId()
    {
        //ユーザID(メールアドレスベース)の@の前部分のみ最大20文字を返す
        $needle = "@";
        $shortUserId = self::$userId;
        if(mb_strpos($shortUserId, $needle) !== false){
            $shortUserId = mb_substr($shortUserId,0,mb_strpos($shortUserId, $needle));
        }
        if(mb_strlen($shortUserId) > 20) {
            $shortUserId = mb_substr($shortUserId, 0, 20);
        }
        return $shortUserId;
    }

    /**
     * @return mixed
     */
    public static function getLoginId()
    {
        return self::$loginId;
    }

    public static function getLogger()
    {
        return self::$logger;
    }

    public static function getUserNo()
    {
        if (self::$userNo === null) {
            self::$userNo = PHP_INT_MAX;
        }
        return self::$userNo;
    }

    public static function setUserNo($userNo)
    {
        self::$userNo = $userNo;
    }
    // DBのデータ長が不足しているので、20文字で保存時はカットします
    public static function getProgramId()
    {
      $shortProgramId = null;
      if (is_object(self::$programId) && self::$programId instanceof Closure) {
            $closure = self::$programId;
            $shortProgramId = $closure();
            if(mb_strlen($shortProgramId) > 20) {
              $shortProgramId = mb_substr($shortProgramId, 0, 20);
            }
            return $shortProgramId;
        }

      $shortProgramId = self::$programId;
      if(mb_strlen($shortProgramId) > 20) {
        $shortProgramId = mb_substr($shortProgramId, 0, 20);
        }
      return $shortProgramId;
    }

    public static function setProgramId($programId)
    {
        self::$programId = $programId;
    }

    public static function getFullProgramId()
    {
        if (is_object(self::$programId) && self::$programId instanceof Closure) {
            $closure = self::$programId;
            return $closure();
        }
        return self::$programId;
    }

}
