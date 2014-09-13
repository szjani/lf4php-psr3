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
use PHPUnit_Framework_TestCase;

class Psr3ParamHolderTest extends PHPUnit_Framework_TestCase
{
    public function testConversionWithoutException()
    {
        $lf4phpFormat = "{} {}!";
        $lf4phpParams = array("Hello", "World");
        $holder = Psr3ParamHolder::create($lf4phpFormat, $lf4phpParams);
        self::assertEquals("{0} {1}!", $holder->getMessage());
        self::assertSame(array('0' => $lf4phpParams[0], '1' => $lf4phpParams[1]), $holder->getContext());
    }

    public function testWithException()
    {
        $lf4phpFormat = "{} {}!";
        $lf4phpParams = array("Hello", "World");
        $exception = new Exception('Ouch');
        $holder = Psr3ParamHolder::create($lf4phpFormat, $lf4phpParams, $exception);
        self::assertEquals("{0} {1}!", $holder->getMessage());
        self::assertSame(
            array('0' => $lf4phpParams[0], '1' => $lf4phpParams[1], 'exception' => $exception),
            $holder->getContext()
        );
    }
}
