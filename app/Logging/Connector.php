<?php
namespace App\Logging;

use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\UidProcessor;
use Monolog\Processor\WebProcessor;

class Connector
{
    public function __invoke($logging)
    {

        $formatter = new Formatter();

        $introspectionProcessor = new IntrospectionProcessor(
            Logger::DEBUG,
            [
                'Illuminate\\'
                ,'App\\Core\\Logger'
            ]
        );

        $webProcessor = new WebProcessor();
        $uidProcessor = new UidProcessor();
        $processor = new Processor();

        foreach($logging->getHandlers() as $handler) {
            $handler->setFormatter($formatter);
            $handler->pushProcessor($introspectionProcessor);
            $handler->pushProcessor($webProcessor);
            $handler->pushProcessor($uidProcessor);
            $handler->pushProcessor($processor);
        }
    }

}
