<?php

namespace Test\Leaditin\Code\Generator;

use Exception;
use Leaditin\Code\DocBlock;
use Leaditin\Code\Generator\DocBlockGenerator;
use Leaditin\Code\Generator\Factory;
use Leaditin\Code\Tag;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Generator\DocBlockGenerator
 */
final class DocBlockGeneratorTest extends TestCase
{
    /**
     * @var DocBlockGenerator
     */
    private $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generator = (new Factory())->docBlockGenerator();
    }

    public function docBlockDataProvider(): array
    {
        return [
            [
                'docBlock' => new DocBlock(
                    $shortDescription = $this->anything()->toString(),
                    $longDescription = $this->anything()->toString(),
                    [
                        new Tag(
                            $name = $this->anything()->toString(),
                            $value = $this->anything()->toString(),
                            $description = $this->anything()->toString()
                        )
                    ]
                ),
                'expected' => <<<EOL
/**
 * $shortDescription
 *
 * $longDescription
 *
 * @$name $value $description
 */
EOL
            ],
            [
                'docBlock' => new DocBlock(
                    null,
                    null,
                    [
                        new Tag(
                            $name = 'throws',
                            $value = Exception::class
                        )
                    ]
                ),
                'expected' => <<<EOL
/**
 * @$name $value
 */
EOL
            ],
            [
                'docBlock' => new DocBlock(
                    $shortDescription = $this->anything()->toString()
                ),
                'expected' => <<<EOL
/**
 * $shortDescription
 */
EOL
            ],
            [
                'docBlock' => new DocBlock(),
                'expected' => '',
            ],
            [
                'docBlock' => new DocBlock(
                    $shortDescription = $this->anything()->toString(),
                    null,
                    [
                        new Tag('property', '$someProperty'),
                        new Tag('', ''),
                        new Tag('method', 'someMethod()'),
                    ]
                ),
                'expected' => <<<EOL
/**
 * $shortDescription
 *
 * @property \$someProperty
 *
 * @method someMethod()
 */
EOL
            ],
        ];
    }

    /**
     * @dataProvider docBlockDataProvider
     *
     * @param DocBlock $docBlock
     * @param string $expected
     */
    public function testGenerator(DocBlock $docBlock, string $expected): void
    {
        $this->assertSame($expected, $this->generator->generate($docBlock));
    }
}
