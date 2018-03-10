<?php
declare(strict_types=1);

namespace lf4php\impl;

use Exception;
use PHPUnit\Framework\TestCase;

class Psr3ParamHolderTest extends TestCase
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
