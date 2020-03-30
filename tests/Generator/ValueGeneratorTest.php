<?php

namespace Test\Leaditin\Code\Generator;

use Leaditin\Code\Generator\Factory;
use Leaditin\Code\Generator\ValueGenerator;
use Leaditin\Code\Value;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Generator\ValueGenerator
 */
final class ValueGeneratorTest extends TestCase
{
    /**
     * @var ValueGenerator
     */
    private $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generator = (new Factory())->valueGenerator();
    }

    public function valueDataProvider(): array
    {
        return [
            [
                'value' => new Value(null),
                'expected' => 'null'
            ],
            [
                'value' => new Value(true),
                'expected' => 'true'
            ],
            [
                'value' => new Value(false),
                'expected' => 'false'
            ],
            [
                'value' => new Value('string'),
                'expected' => "'string'"
            ],
            [
                'value' => new Value("string's"),
                'expected' => "'string\\'s'"
            ],
            [
                'value' => new Value(12),
                'expected' => '12'
            ],
            [
                'value' => new Value([]),
                'expected' => '[]'
            ],
            [
                'value' => new Value(['a', 1]),
                'expected' => '[\'a\', 1]'
            ],
            [
                'value' => new Value(1.02),
                'expected' => '1.02'
            ],
            [
                'value' => new Value(new self()),
                'expected' => self::class
            ],
            [
                'value' => new Value('self::class'),
                'expected' => 'self::class'
            ],
        ];
    }

    /**
     * @dataProvider valueDataProvider
     *
     * @param Value $value
     * @param string $expected
     */
    public function testGenerate(Value $value, string $expected): void
    {
        $this->assertSame($expected, $this->generator->generate($value));
    }
}
