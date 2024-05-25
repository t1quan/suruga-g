<?php

namespace App\Models\L3;

use App\Core\Logger\Logger;

/**
 * @method exec($msg)
 */
abstract class L3Abstract {

    protected $msg;

    public function __construct() {
    }

    public final function execute($msg) {
        $this->beforeExec($msg);
        $this->exec($msg);
        $this->afterExec($msg);
    }

    protected function beforeExec(/** @noinspection PhpUnusedParameterInspection */ $msg) {
        Logger::debugTrace('start ' . get_class($this));
    }

//    abstract protected function exec($msg);

    protected function afterExec(/** @noinspection PhpUnusedParameterInspection */ $msg) {
        Logger::debugTrace('end** ' . get_class($this));
    }

}
