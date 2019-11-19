<?php

namespace Test\Leaditin\Code\Generator;

use Leaditin\Code\Generator\Factory;
use Leaditin\Code\Generator\VisibilityGenerator;
use Leaditin\Code\Visibility;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Generator\VisibilityGenerator
 */
final class VisibilityGeneratorTest extends TestCase
{
    /**
     * @var VisibilityGenerator
     */
    private $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generator = (new Factory())->visibilityGenerator();
    }

    public function visibilityDataProvider(): array
    {
        return [
            [
                'visibility' => new Visibility(Visibility::VISIBILITY_PUBLIC),
                'expected' => 'public'
            ],
            [
                'visibility' => new Visibility(Visibility::VISIBILITY_PROTECTED),
                'expected' => 'protected'
            ],
            [
                'visibility' => new Visibility(Visibility::VISIBILITY_PRIVATE),
                'expected' => 'private'
            ]
        ];
    }

    /**
     * @dataProvider visibilityDataProvider
     *
     * @param Visibility $visibility
     * @param string $expected
     */
    public function testGenerate(Visibility $visibility, string $expected): void
    {
        $this->assertSame($expected, $this->generator->generate($visibility));
    }
}
