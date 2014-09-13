<?php
/*
 * Copyright (c) 2014 Szurovecz János
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
 * of the Software, and to permit persons to whom the Software is furnished to do
 * so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

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

    public function __construct(LoggerInterface $psr3Logger, $name)
    {
        $this->psr3Logger = $psr3Logger;
        $this->name = $name;
        $this->setLocationPrefix('');
    }

    /**
     * @return LoggerInterface
     */
    public function getPsr3Logger()
    {
        return $this->psr3Logger;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return boolean
     */
    public function isDebugEnabled()
    {
        return true;
    }

    /**
     * @return boolean
     */
    public function isErrorEnabled()
    {
        return true;
    }

    /**
     * @return boolean
     */
    public function isInfoEnabled()
    {
        return true;
    }

    /**
     * @return boolean
     */
    public function isTraceEnabled()
    {
        return true;
    }

    /**
     * @return boolean
     */
    public function isWarnEnabled()
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

    protected function getFormattedLocation()
    {
        return $this->getLocationPrefix()
            . $this->getShortLocation(self::DEFAULT_BACKTRACE_LEVEL + 1)
            . $this->getLocationSuffix();
    }
}
