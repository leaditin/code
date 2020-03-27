<?php

namespace Test\Leaditin\Code\Generator;

use Leaditin\Code\Generator\Factory;
use Leaditin\Code\Generator\TypeGenerator;
use Leaditin\Code\Type;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Generator\TypeGenerator
 */
final class TypeGeneratorTest extends TestCase
{
    /**
     * @var TypeGenerator
     */
    private $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generator = (new Factory())->typeGenerator();
    }

    public function typeDataProvider(): array
    {
        return [
            [
                'type' => new Type(Type::TYPE_BOOL, false),
                'expected' => 'bool'
            ],
            [
                'type' => new Type(Type::TYPE_BOOL, true),
                'expected' => '?bool'
            ],
            [
                'type' => new Type(Type::TYPE_INT, false),
                'expected' => 'int'
            ],
            [
                'type' => new Type(Type::TYPE_INT, true),
                'expected' => '?int'
            ],
            [
                'type' => new Type(Type::TYPE_FLOAT, false),
                'expected' => 'float'
            ],
            [
                'type' => new Type(Type::TYPE_FLOAT, true),
                'expected' => '?float'
            ],
            [
                'type' => new Type(Type::TYPE_STRING, false),
                'expected' => 'string'
            ],
            [
                'type' => new Type(Type::TYPE_STRING, true),
                'expected' => '?string'
            ],
            [
                'type' => new Type(Type::TYPE_ARRAY, false),
                'expected' => 'array'
            ],
            [
                'type' => new Type(Type::TYPE_ARRAY, true),
                'expected' => '?array'
            ],
            [
                'type' => new Type(Type::TYPE_CALLABLE, false),
                'expected' => 'callable'
            ],
            [
                'type' => new Type(Type::TYPE_CALLABLE, true),
                'expected' => '?callable'
            ],
            [
                'type' => new Type(Type::TYPE_MIXED, false),
                'expected' => ''
            ],
            [
                'type' => new Type(Type::TYPE_MIXED, true),
                'expected' => ''
            ],
            [
                'type' => new Type(Type::TYPE_VOID, false),
                'expected' => 'void'
            ],
            [
                'type' => new Type(Type::TYPE_VOID, true),
                'expected' => 'void'
            ],
            [
                'type' => new Type(self::class, false),
                'expected' => self::class
            ],
        ];
    }

    /**
     * @dataProvider typeDataProvider
     *
     * @param Type $type
     * @param string $expected
     */
    public function testGenerate(Type $type, string $expected): void
    {
        $this->assertSame($expected, $this->generator->generate($type));
    }
}
