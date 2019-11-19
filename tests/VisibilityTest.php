<?php

namespace Test\Leaditin\Code;

use InvalidArgumentException;
use Leaditin\Code\Flag;
use Leaditin\Code\Visibility;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Visibility
 */
final class VisibilityTest extends TestCase
{
    public function constructorArgumentsDataProvider(): array
    {
        return [
            [Visibility::VISIBILITY_PUBLIC],
            [Visibility::VISIBILITY_PROTECTED],
            [Visibility::VISIBILITY_PRIVATE],
        ];
    }

    /**
     * @dataProvider constructorArgumentsDataProvider
     *
     * @param string $visibility
     */
    public function testGetters(string $visibility): void
    {
        $obj = new Visibility($visibility);

        $this->assertSame($visibility, $obj->visibility());
    }

    public function invalidConstructorArgumentsDataProvider(): array
    {
        return [
            ['dummy'],
            [$this->anything()->toString()],
        ];
    }

    /**
     * @dataProvider invalidConstructorArgumentsDataProvider
     *
     * @param string $visibility
     */
    public function testExceptionOnInvalidVisibility(string $visibility): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Visibility '$visibility' is not valid visibility case.");

        new Visibility($visibility);
    }

    public function fromFlagDataProvider(): array
    {
        return [
            [new Flag(Flag::FLAG_PUBLIC), Visibility::VISIBILITY_PUBLIC],
            [new Flag(Flag::FLAG_PROTECTED), Visibility::VISIBILITY_PROTECTED],
            [new Flag(Flag::FLAG_PRIVATE), Visibility::VISIBILITY_PRIVATE],
        ];
    }

    /**
     * @dataProvider fromFlagDataProvider
     *
     * @param Flag $flag
     * @param string $expected
     */
    public function testFromFlag(Flag $flag, string $expected): void
    {
        $visibility = Visibility::fromFlag($flag);

        $this->assertSame($expected, $visibility->visibility());
    }
}
