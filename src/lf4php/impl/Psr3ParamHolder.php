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

class Psr3ParamHolder
{
    private $message;
    private $context;

    private function __construct($message, array $context = array())
    {
        $this->message = $message;
        $this->context = $context;
    }

    /**
     * @param $lf4phpFormat
     * @param array $lf4phpParams
     * @param Exception $exception
     * @return Psr3ParamHolder
     */
    public static function create($lf4phpFormat, array $lf4phpParams = array(), Exception $exception = null)
    {
        $counter = -1;
        $message = preg_replace_callback(
            '#{}#',
            function () use (&$counter) {
                $counter++;
                return "{{$counter}}";
            },
            $lf4phpFormat
        );
        $context = $lf4phpParams;
        if ($exception !== null) {
            $context['exception'] = $exception;
        }
        return new Psr3ParamHolder($message, $context);
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getContext()
    {
        return $this->context;
    }
}
