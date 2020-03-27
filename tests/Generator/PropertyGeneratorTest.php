<?php

namespace Test\Leaditin\Code\Generator;

use Leaditin\Code\Flag;
use Leaditin\Code\Generator\Factory;
use Leaditin\Code\Generator\PropertyGenerator;
use Leaditin\Code\Member\Property;
use Leaditin\Code\Type;
use Leaditin\Code\Value;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Generator\MemberGenerator
 * @covers \Leaditin\Code\Generator\PropertyGenerator
 */
final class PropertyGeneratorTest extends TestCase
{
    /**
     * @var PropertyGenerator
     */
    private $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generator = (new Factory())->propertyGenerator();
    }

    public function propertyDataProvider(): array
    {
        return [
            [
                'argument' => new Property('string', new Value('eur'), new Type(Type::TYPE_STRING), new Flag(Flag::FLAG_PUBLIC)),
                'expected' => <<<EOL
    /**
     * @var string
     */
    public \$string = 'eur';
EOL
            ],
            [
                'argument' => new Property('array', new Value([1, 2]), new Type(Type::TYPE_ARRAY), new Flag(Flag::FLAG_PROTECTED)),
                'expected' => <<<EOL
    /**
     * @var array
     */
    protected \$array = [1, 2];
EOL
            ],
            [
                'argument' => new Property('bool', new Value(true), new Type(Type::TYPE_BOOL), new Flag(Flag::FLAG_PRIVATE)),
                'expected' => <<<EOL
    /**
     * @var bool
     */
    private \$bool = true;
EOL
            ],
            [
                'argument' => new Property('class', new Value(), new Type($type = Type::class), new Flag(Flag::FLAG_STATIC)),
                'expected' => <<<EOL
    /**
     * @var $type
     */
    public static \$class;
EOL
            ],
        ];
    }

    /**
     * @dataProvider propertyDataProvider
     *
     * @param Property $property
     * @param string $expected
     */
    public function testGenerate(Property $property, string $expected): void
    {
        $this->assertSame($expected, $this->generator->generate($property));
    }
}
