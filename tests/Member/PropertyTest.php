<?php

namespace Test\Leaditin\Code\Member;

use Leaditin\Code\Flag;
use Leaditin\Code\Member\Property;
use Leaditin\Code\Type;
use Leaditin\Code\Value;
use Leaditin\Code\Visibility;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Member\Property
 */
final class PropertyTest extends TestCase
{
    public function constructorArgumentsDataProvider(): array
    {
        return [
            [
                'name' => $this->anything()->toString(),
                'defaultValue' => $this->createMock(Value::class),
                'type' => $this->createMock(Type::class),
            ]
        ];
    }

    /**
     * @dataProvider constructorArgumentsDataProvider
     *
     * @param string $name
     * @param Value $defaultValue
     * @param Type $type
     */
    public function testGetters(string $name, Value $defaultValue, Type $type): void
    {
        $property = new Property($name, $defaultValue, $type);

        $this->assertSame($name, $property->name());
        $this->assertSame($defaultValue, $property->defaultValue());
        $this->assertSame($type, $property->type());
    }

    public function visibilityDataProvider(): array
    {
        return [
            [
                'flag' => null,
                'visibility' => Visibility::VISIBILITY_PUBLIC,
            ],
            [
                'flag' => new Flag(Flag::FLAG_PUBLIC),
                'expected' => Visibility::VISIBILITY_PUBLIC
            ],
            [
                'flag' => new Flag(Flag::FLAG_PROTECTED),
                'expected' => Visibility::VISIBILITY_PROTECTED
            ],
            [
                'flag' => new Flag(Flag::FLAG_PRIVATE),
                'expected' => Visibility::VISIBILITY_PRIVATE
            ],
        ];
    }

    /**
     * @dataProvider visibilityDataProvider
     *
     * @param null|Flag $flag
     * @param string $expected
     */
    public function testVisibility(?Flag $flag, string $expected): void
    {
        $property = $this->getDummyProperty($flag);

        $this->assertSame($expected, $property->visibility()->visibility());
    }

    public function testStaticProperty(): void
    {
        $property = $this->getDummyProperty();
        $property->setStatic(true);

        $this->assertTrue($property->isStatic());

        $property = $this->getDummyProperty(new Flag(Flag::FLAG_STATIC));
        $this->assertTrue($property->isStatic());

        $property->setStatic(false);
        $this->assertFalse($property->isStatic());
    }

    /**
     * @param null|Flag $flag
     *
     * @return Property
     */
    private function getDummyProperty(Flag $flag = null): Property
    {
        return new Property(
            $this->anything()->toString(),
            $this->createMock(Value::class),
            $this->createMock(Type::class),
            $flag
        );
    }
}
