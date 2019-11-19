<?php

namespace Test\Leaditin\Code\Generator;

use Leaditin\Code\Generator\ArgumentGenerator;
use Leaditin\Code\Generator\Factory;
use Leaditin\Code\Member\Argument;
use Leaditin\Code\Type;
use Leaditin\Code\Value;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Generator\ArgumentGenerator
 */
final class ArgumentGeneratorTest extends TestCase
{
    /**
     * @var ArgumentGenerator
     */
    private $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generator = (new Factory())->argumentGenerator();
    }

    public function argumentDataProvider(): array
    {
        return [
            [
                'argument' => new Argument('string', new Type(Type::TYPE_STRING), new Value(), false, false),
                'expected' => 'string $string'
            ],
            [
                'argument' => new Argument('int', new Type(Type::TYPE_INT), new Value(), false, true),
                'int ...$int'
            ],
            [
                'argument' => new Argument('array', new Type(Type::TYPE_ARRAY), new Value(), true, false),
                'expected' => 'array &$array'
            ],
            [
                'argument' => new Argument('mixed', new Type(Type::TYPE_MIXED, true), new Value(), false, false),
                'expected' => '$mixed = null'
            ],
            [
                'argument' => new Argument('bool', new Type(Type::TYPE_BOOL), new Value(true), false, false),
                'expected' => 'bool $bool = true'
            ],
            [
                'argument' => new Argument('class', new Type(Type::class), new Value(), true, false),
                'expected' => '\\' . Type::class . ' $class'
            ],
        ];
    }

    /**
     * @dataProvider argumentDataProvider
     *
     * @param Argument $argument
     * @param string $expected
     */
    public function testArgumentGenerator(Argument $argument, string $expected): void
    {
        $this->assertSame($expected, $this->generator->generate($argument));
    }
}
