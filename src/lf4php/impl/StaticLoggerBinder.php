<?php
declare(strict_types=1);


namespace lf4php\impl;

/**
 * StaticLoggerBinder for PSR-3.
 *
 * @package lf4php\impl
 * @author Janos Szurovecz <szjani@szjani.hu>
 */
final class StaticLoggerBinder
{
    /**
     * @var StaticLoggerBinder
     */
    public static $SINGLETON;

    private $loggerFactory;

    public static function init() : void
    {
        self::$SINGLETON = new StaticLoggerBinder();
        self::$SINGLETON->loggerFactory = new Psr3LoggerFactory();
    }

    /**
     * @return Psr3LoggerFactory
     */
    public function getLoggerFactory() : Psr3LoggerFactory
    {
        return $this->loggerFactory;
    }
}
StaticLoggerBinder::init();
