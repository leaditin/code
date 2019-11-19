<?php

namespace Test\Leaditin\Code\Generator;

use Leaditin\Code\Generator\ConstantGenerator;
use Leaditin\Code\Generator\Factory;
use Leaditin\Code\Member\Constant;
use Leaditin\Code\Visibility;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Generator\ConstantGenerator
 */
final class ConstantGeneratorTest extends TestCase
{
    /**
     * @var ConstantGenerator
     */
    private $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generator = (new Factory())->constantGenerator();
    }

    public function constantDataProvider(): array
    {
        return [
            [
                'constant' => new Constant('STRING', 'Example', new Visibility(Visibility::VISIBILITY_PUBLIC)),
                'expected' => '    public const STRING = \'Example\';'
            ],
            [
                'constant' => new Constant('BOOLEAN', true, new Visibility(Visibility::VISIBILITY_PROTECTED)),
                'expected' => '    protected const BOOLEAN = true;'
            ],
            [
                'constant' => new Constant('INTEGER', 12, new Visibility(Visibility::VISIBILITY_PRIVATE)),
                'expected' => '    private const INTEGER = 12;'
            ],
            [
                'constant' => new Constant('FLOAT', 12.3, new Visibility(Visibility::VISIBILITY_PUBLIC)),
                'expected' => '    public const FLOAT = 12.3;'
            ],
            [
                'constant' => new Constant('ARRAY', [], new Visibility(Visibility::VISIBILITY_PROTECTED)),
                'expected' => '    protected const ARRAY = [];'
            ],
        ];
    }

    /**
     * @dataProvider constantDataProvider
     *
     * @param Constant $constant
     * @param string $expected
     */
    public function testGenerate(Constant $constant, string $expected): void
    {
        $this->assertSame($expected, $this->generator->generate($constant));
    }
}
