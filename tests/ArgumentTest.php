<?php

namespace Test\Leaditin\Code;

use Leaditin\Code\Argument;
use Leaditin\Code\Type;
use Leaditin\Code\Value;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Argument
 */
final class ArgumentTest extends TestCase
{
    public function constructorArgumentsDataProvider(): array
    {
        return [
            [
                'name' => $this->anything()->toString(),
                'type' => $this->createMock(Type::class),
                'defaultValue' => $this->createMock(Value::class),
                'isReference' => false,
                'isVariadic' => false,
            ]
        ];
    }

    /**
     * @dataProvider constructorArgumentsDataProvider
     *
     * @param string $name
     * @param Type $type
     * @param Value $defaultValue
     * @param bool $isReference
     * @param bool $isVariadic
     */
    public function testGetters(string $name, Type $type, Value $defaultValue, bool $isReference = false, bool $isVariadic = false): void
    {
        $argument = new Argument($name, $type, $defaultValue, $isReference, $isVariadic);

        $this->assertSame($name, $argument->name());
        $this->assertSame($type, $argument->type());
        $this->assertSame($defaultValue, $argument->defaultValue());
        $this->assertSame($isReference, $argument->isReference());
        $this->assertSame($isVariadic, $argument->isVariadic());
    }
}
