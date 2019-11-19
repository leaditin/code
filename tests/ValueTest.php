<?php

namespace Test\Leaditin\Code;

use Leaditin\Code\Value;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Value
 */
final class ValueTest extends TestCase
{
    public function constructorArgumentsDataProvider(): array
    {
        return [
            [null],
            [$this->anything()->toString()],
            [[1, 2, 3]],
        ];
    }

    /**
     * @dataProvider constructorArgumentsDataProvider
     *
     * @param null|mixed $value
     */
    public function testGetters($value): void
    {
        $obj = new Value($value);

        $this->assertSame($value, $obj->value());
    }
}
