<?php

namespace Test\Leaditin\Code\Member;

use Leaditin\Code\Member\Constant;
use Leaditin\Code\Value;
use Leaditin\Code\Visibility;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Member\Constant
 */
final class ConstantTest extends TestCase
{
    public function constructorArgumentsDataProvider(): array
    {
        return [
            [
                'name' => $this->anything()->toString(),
                'value' => $this->createMock(Value::class),
                'visibility' => $this->createMock(Visibility::class),
            ]
        ];
    }

    /**
     * @dataProvider constructorArgumentsDataProvider
     *
     * @param string $name
     * @param Value $value
     * @param Visibility $visibility
     */
    public function testGetters(string $name, Value $value, Visibility $visibility): void
    {
        $constant = new Constant($name, $value, $visibility);

        $this->assertSame($name, $constant->name());
        $this->assertSame($value, $constant->value());
        $this->assertSame($visibility, $constant->visibility());
    }
}
