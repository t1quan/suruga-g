<?php

namespace App\Models\L2;

use App\Core\Logger\Logger;

/**
 * Class L2Abstract
 * @method exec($msg)
 */
abstract class L2Abstract {

    protected $msg;

    public function __construct() {
    }

    public final function execute($msg) {
        $this->beforeExec($msg);
        $responseCd = $this->exec($msg);
        $this->afterExec($msg);

        if ($responseCd) {
            return $responseCd;
        }
    }

    protected function beforeExec(/** @noinspection PhpUnusedParameterInspection */ $msg) {
        if(env('APP_ENV') === 'production' || env('APP_DEBUG') === false) {//本番環境、もしくは非デバッグモードの場合
            Logger::infoTrace('start ' . get_class($this)); //ログ出力内容削減
        }
        else {
            Logger::infoTrace('start ' . get_class($this), $msg);
        }
    }

//    abstract protected function exec($msg);

    protected function afterExec(/** @noinspection PhpUnusedParameterInspection */ $msg) {
        if(env('APP_ENV') === 'production' || env('APP_DEBUG') === false) { //本番環境、もしくは非デバッグモードの場合
            Logger::infoTrace('end** ' . get_class($this)); //ログ出力内容削減
        }
        else {
            Logger::infoTrace('end** ' . get_class($this), $msg);
        }
    }
}
