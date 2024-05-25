<?php

namespace App\Models\L1;

use App\Core\Logger\Logger;
use Illuminate\Http\JsonResponse;

/**
 * @method exec($msg)
 */
abstract class L1Abstract {

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

    //本番環境、もしくは非デバッグモードの場合でもMsgを出力したいClassを指定
    protected $dispMsgLogList = array (
        'SaveApply',
    );

    protected function beforeExec(/** @noinspection PhpUnusedParameterInspection */ $msg) {
        if(env('APP_ENV') === 'production' || env('APP_DEBUG') === false) {//本番環境、もしくは非デバッグモードの場合
            foreach($this->dispMsgLogList As $list) {
                if(str_ends_with(get_class($this),$list)) { //後方一致でクラス名を確認
                    Logger::infoTrace('start ' . get_class($this), $msg); //Msg付きのログを出力する
                    return;
                }
            }
            Logger::infoTrace('start ' . get_class($this)); //ログ出力内容削減
        }
        else {
            Logger::infoTrace('start ' . get_class($this), $msg);
        }
    }
//    abstract protected function exec($msg);

    protected function afterExec(/** @noinspection PhpUnusedParameterInspection */ $msg) {
        if($msg->_c !== JsonResponse::HTTP_OK) {
            Logger::ErrorTrace('Error occurred at: ' . get_class($this), [$msg->_c, $msg->_m]); //エラーログ出力
            return;
        }
        if(env('APP_ENV') === 'production' || env('APP_DEBUG') === false) { //本番環境、もしくは非デバッグモードの場合
            foreach($this->dispMsgLogList As $list) {
                if(str_ends_with(get_class($this),$list)) { //後方一致でクラス名を確認
                    Logger::infoTrace('end** ' . get_class($this), $msg); //Msg付きのログを出力する
                    return;
                }
            }
            Logger::infoTrace('end** ' . get_class($this)); //ログ出力内容削減
        }
        else {
            Logger::infoTrace('end** ' . get_class($this), $msg);
        }
    }

}
