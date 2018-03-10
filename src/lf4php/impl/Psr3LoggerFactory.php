<?php
declare(strict_types=1);

namespace lf4php\impl;

use lf4php\CachedClassLoggerFactory;
use lf4php\Logger;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class Psr3LoggerFactory extends CachedClassLoggerFactory
{
    const ROOT_LOGGER_NAME = 'ROOT';

    public function __construct()
    {
        parent::__construct(new Psr3LoggerAdapter(new NullLogger(), self::ROOT_LOGGER_NAME));
    }

    public function registerPsr3Logger(string $classOrNamespace, LoggerInterface $logger) : void
    {
        $this->registerLogger($classOrNamespace, new Psr3LoggerAdapter($logger, $classOrNamespace));
    }

    public function setRootPsr3Logger(LoggerInterface $logger) : void
    {
        $this->setRootLogger(new Psr3LoggerAdapter($logger, self::ROOT_LOGGER_NAME));
    }
}
