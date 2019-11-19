<?php

namespace Test\Leaditin\Code\Member;

use Leaditin\Code\Flag;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Flag
 */
final class FlagTest extends TestCase
{
    public function flagDataProvider(): array
    {
        return [
            [Flag::FLAG_PUBLIC],
            [Flag::FLAG_PROTECTED],
            [Flag::FLAG_PRIVATE],
            [Flag::FLAG_ABSTRACT],
            [Flag::FLAG_FINAL],
            [Flag::FLAG_STATIC],
        ];
    }

    /**
     * @dataProvider flagDataProvider
     *
     * @param int $flags
     */
    public function testHasFlag(int $flags): void
    {
        $flag = new Flag($flags);

        $this->assertTrue($flag->hasFlag($flags));
    }

    /**
     * @dataProvider flagDataProvider
     *
     * @param int $flags
     */
    public function testAddFlag(int $flags): void
    {
        $flag = new Flag();
        $this->assertFalse($flag->hasFlag($flags));

        $flag->addFlag($flags);
        $this->assertTrue($flag->hasFlag($flags));
    }

    /**
     * @dataProvider flagDataProvider
     *
     * @param int $flags
     */
    public function testRemoveFlag(int $flags): void
    {
        $flag = new Flag($flags);
        $this->assertTrue($flag->hasFlag($flags));

        $flag->removeFlag($flags);
        $this->assertFalse($flag->hasFlag($flags));
    }
}
