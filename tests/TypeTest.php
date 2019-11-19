<?php

namespace Test\Leaditin\Code;

use Leaditin\Code\Type;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Type
 */
final class TypeTest extends TestCase
{
    public function constructorArgumentsDataProvider(): array
    {
        return [
            [
                'type' => Type::TYPE_STRING,
                'isNullable' => true,
                'isScalar' => true,
            ],
            [
                'type' => Type::TYPE_CALLABLE,
                'isNullable' => false,
                'isScalar' => false,
            ],
        ];
    }

    /**
     * @dataProvider constructorArgumentsDataProvider
     *
     * @param string $type
     * @param bool $isNullable
     * @param bool $isScalar
     */
    public function testGetters(string $type, bool $isNullable, bool $isScalar): void
    {
        $obj = new Type($type, $isNullable);

        $this->assertSame($type, $obj->type());
        $this->assertSame($isNullable, $obj->isNullable());
        $this->assertSame($isScalar, $obj->isScalar());
    }
}
