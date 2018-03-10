<?php
declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use lf4php\impl\StaticLoggerBinder;
use lf4php\LoggerFactory;
use lf4php\MDC;
use lf4php\SimpleStdoutLogger;

// initialize PSR-3 logger
$logger = new SimpleStdoutLogger();

// configure lf4php
StaticLoggerBinder::$SINGLETON->getLoggerFactory()->setRootPsr3Logger($logger);

// logging
$logger = LoggerFactory::getLogger('default');

// PSR-3 binder does not support MDC, it will be ignored
MDC::put('IP', '127.0.0.1');
$logger->error('Hello World!', array(), new Exception());
$logger->info(Test::getException());

class Test
{
    public static function getException()
    {
        LoggerFactory::getLogger(__CLASS__)->debug(__METHOD__);
        MDC::clear();
        return new Exception('ouch');
    }
}
