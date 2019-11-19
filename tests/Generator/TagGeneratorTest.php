<?php

namespace Test\Leaditin\Code\Generator;

use Leaditin\Code\Generator\Factory;
use Leaditin\Code\Generator\TagGenerator;
use Leaditin\Code\Tag;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Generator\TagGenerator
 */
class TagGeneratorTest extends TestCase
{
    /**
     * @var TagGenerator
     */
    private $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generator = (new Factory())->tagGenerator();
    }

    public function tagDataProvider(): array
    {
        return [
            [
                'tag' => new Tag('author', 'Somebody', null),
                'expected' => '@author Somebody'
            ],
            [
                'tag' => new Tag('method', 'bool someMethod()', null),
                'expected' => '@method bool someMethod()'
            ],
            [
                'tag' => new Tag('property', 'string $someProperty', 'Explains some property'),
                'expected' => '@property string $someProperty Explains some property'
            ],
        ];
    }

    /**
     * @dataProvider tagDataProvider
     *
     * @param Tag $tag
     * @param string $output
     */
    public function testGenerate(Tag $tag, string $output): void
    {
        $this->assertSame($output, $this->generator->generate($tag));
    }
}
