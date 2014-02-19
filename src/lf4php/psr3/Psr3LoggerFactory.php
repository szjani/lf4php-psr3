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

namespace lf4php\psr3;

use lf4php\CachedClassLoggerFactory;
use lf4php\Logger;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class Psr3LoggerFactory extends CachedClassLoggerFactory
{
    const ROOT_LOGGER_NAME = 'ROOT';

    public function __construct()
    {
        parent::__construct(new Psr3LoggerWrapper(new NullLogger(), self::ROOT_LOGGER_NAME));
    }

    public function registerPsr3Logger($classOrNamespace, LoggerInterface $logger)
    {
        $this->registerLogger($classOrNamespace, new Psr3LoggerWrapper($logger, $classOrNamespace));
    }
}
