<?php
declare(strict_types=1);

namespace lf4php\impl;

use Exception;
use lf4php\LocationLogger;
use Psr\Log\LoggerInterface;

class Psr3LoggerAdapter extends LocationLogger
{
    /**
     * @var LoggerInterface
     */
    private $psr3Logger;

    /**
     * @var string
     */
    private $name;

    public function __construct(LoggerInterface $psr3Logger, string $name)
    {
        $this->psr3Logger = $psr3Logger;
        $this->name = $name;
        $this->setLocationPrefix('');
    }

    /**
     * @return LoggerInterface
     */
    public function getPsr3Logger() : LoggerInterface
    {
        return $this->psr3Logger;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return boolean
     */
    public function isDebugEnabled() : bool
    {
        return true;
    }

    /**
     * @return boolean
     */
    public function isErrorEnabled() : bool
    {
        return true;
    }

    /**
     * @return boolean
     */
    public function isInfoEnabled() : bool
    {
        return true;
    }

    /**
     * @return boolean
     */
    public function isTraceEnabled() : bool
    {
        return true;
    }

    /**
     * @return boolean
     */
    public function isWarnEnabled() : bool
    {
        return true;
    }

    /**
     * @param string $format
     * @param mixed $params
     * @param Exception $exp
     */
    public function debug($format, $params = array(), Exception $exp = null)
    {
        $holder = Psr3ParamHolder::create($format, $params, $exp);
        $this->psr3Logger->debug($this->getFormattedLocation() . $holder->getMessage(), $holder->getContext());
    }

    /**
     * @param string $format
     * @param mixed $params
     * @param Exception $exp
     */
    public function error($format, $params = array(), Exception $exp = null)
    {
        $holder = Psr3ParamHolder::create($format, $params, $exp);
        $this->psr3Logger->error($this->getFormattedLocation() . $holder->getMessage(), $holder->getContext());
    }

    /**
     * @param string $format
     * @param mixed $params
     * @param Exception $exp
     */
    public function info($format, $params = array(), Exception $exp = null)
    {
        $holder = Psr3ParamHolder::create($format, $params, $exp);
        $this->psr3Logger->info($this->getFormattedLocation() . $holder->getMessage(), $holder->getContext());
    }

    /**
     * @param string $format
     * @param mixed $params
     * @param Exception $exp
     */
    public function trace($format, $params = array(), Exception $exp = null)
    {
        $this->debug($format, $params, $exp);
    }

    /**
     * @param string $format
     * @param mixed $params
     * @param Exception $exp
     */
    public function warn($format, $params = array(), Exception $exp = null)
    {
        $holder = Psr3ParamHolder::create($format, $params, $exp);
        $this->psr3Logger->warning($this->getFormattedLocation() . $holder->getMessage(), $holder->getContext());
    }

    protected function getFormattedLocation() : string
    {
        return $this->getLocationPrefix()
            . $this->getShortLocation(self::DEFAULT_BACKTRACE_LEVEL + 1)
            . $this->getLocationSuffix();
    }
}
