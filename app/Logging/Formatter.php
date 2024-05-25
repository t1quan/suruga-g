<?php

namespace App\Logging;

use Monolog\Formatter\LineFormatter;

class Formatter extends LineFormatter {

//    private $logFormat = '[%datetime%][%extra.ip%][%extra.sid%][%extra.requestId%][%extra.oid%][%extra.loginId%][%extra.class%@%extra.function%(%extra.line%)][%channel%][%level_name%]: %message% %context%' . PHP_EOL;
    private $logFormat = '[%datetime%][%extra.ip%][%extra.sid%][%extra.class%@%extra.function%(%extra.line%)][%channel%][%level_name%]: %message% %context%' . PHP_EOL;

    public function __construct(){
        parent::__construct($this->logFormat, 'Y-m-d H:i:s.v', false, false);
    }

}
