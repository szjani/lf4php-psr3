<?php
declare(strict_types=1);

namespace lf4php\impl;

use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class Psr3LoggerFactoryTest extends TestCase
{
    /**
     * @var Psr3LoggerFactory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new Psr3LoggerFactory();
    }

    public function testRegisterPsr3Logger()
    {
        $psr3Logger = $this->getMockBuilder(LoggerInterface::class)->getMock();
        $this->factory->registerPsr3Logger(__CLASS__, $psr3Logger);

        /* @var $lf4phpLogger \lf4php\impl\Psr3LoggerAdapter */
        $lf4phpLogger = $this->factory->getLogger(__CLASS__);

        self::assertInstanceOf(Psr3LoggerAdapter::class, $lf4phpLogger);
        self::assertSame($psr3Logger, $lf4phpLogger->getPsr3Logger());
    }
}
