<?php

namespace Test\Leaditin\Code;

use Leaditin\Code\DocBlock;
use Leaditin\Code\Tag;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\DocBlock
 */
final class DocBlockTest extends TestCase
{
    public function constructorArgumentsDataProvider(): array
    {
        return [
            [
                'shortDescription' => $this->anything()->toString(),
                'longDescription' => $this->anything()->toString(),
                'tags' => [
                    $this->createMock(Tag::class),
                    $this->createMock(Tag::class)
                ],
            ],
        ];
    }

    /**
     * @dataProvider constructorArgumentsDataProvider
     *
     * @param string $shortDescription
     * @param string $longDescription
     * @param array $tags
     */
    public function testGetters(string $shortDescription, string $longDescription, array $tags): void
    {
        $docBlock = new DocBlock($shortDescription, $longDescription, $tags);

        $this->assertSame($shortDescription, $docBlock->shortDescription());
        $this->assertSame($longDescription, $docBlock->longDescription());
        $this->assertSame($tags, $docBlock->tags());
    }
}
