<?php

namespace Test\Leaditin\Code\Member;

use Leaditin\Code\Tag;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Tag
 */
final class TagTest extends TestCase
{
    public function constructorArgumentsDataProvider(): array
    {
        return [
            [
                'name' => 'author',
                'value' => 'igor@vuckovic.biz',
                'description' => null,
            ],
            [
                'name' => 'method',
                'value' => 'someMethod',
                'description' => 'Some description',
            ],
        ];
    }

    /**
     * @dataProvider constructorArgumentsDataProvider
     *
     * @param string $name
     * @param string $value
     * @param string $description
     */
    public function testGetters(string $name, string $value, ?string $description): void
    {
        $tag = new Tag($name, $value, $description);

        $this->assertSame($name, $tag->name());
        $this->assertSame($value, $tag->value());
        $this->assertSame($description, $tag->description());
    }
}
