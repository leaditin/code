<?php

namespace Test\Leaditin\Code\Generator;

use Leaditin\Code\Generator\Generator;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Generator\Generator
 */
final class GeneratorTest extends TestCase
{
    public function testGetters(): void
    {
        $generator1 = $this->getMockForAbstractClass(Generator::class);
        $generator2 = $this->getMockForAbstractClass(Generator::class);

        $this->assertEquals($generator1, $generator2);

        $generator2->setDepth(1);
        $this->assertNotEquals($generator1, $generator2);
    }
}
