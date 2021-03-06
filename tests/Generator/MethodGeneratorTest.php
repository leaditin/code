<?php

namespace Test\Leaditin\Code\Generator;

use InvalidArgumentException;
use Leaditin\Code\DocBlock;
use Leaditin\Code\Flag;
use Leaditin\Code\Generator\Factory;
use Leaditin\Code\Generator\MethodGenerator;
use Leaditin\Code\Argument;
use Leaditin\Code\Member\Method;
use Leaditin\Code\Tag;
use Leaditin\Code\Type;
use Leaditin\Code\Value;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Generator\MemberGenerator
 * @covers \Leaditin\Code\Generator\MethodGenerator
 */
final class MethodGeneratorTest extends TestCase
{
    /**
     * @var MethodGenerator
     */
    private $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generator = (new Factory())->methodGenerator();
    }

    public function testMethodWithArguments(): void
    {
        $method = new Method(
            'doSomething',
            new Flag(Flag::FLAG_FINAL),
            [
                new Argument('name', new Type(Type::TYPE_STRING), new Value()),
                new Argument('email', new Type(Type::TYPE_STRING, true), new Value()),
            ],
            'return "@author $name <@email>";',
            new DocBlock(
                'Some example',
                null,
                [
                    new Tag('param', 'string $name Defines name')
                ]
            ),
            new Type(Type::TYPE_STRING)
        );

        $expected = <<<EOL
    /**
     * Some example
     *
     * @param string \$name Defines name
     * @param null|string \$email
     *
     * @return string
     */
    final public function doSomething(string \$name, string \$email = null): string
    {
        return "@author \$name <@email>";
    }
EOL;

        $this->assertSame($expected, $this->generator->generate($method));
    }

    public function testMethodWithDocBlock(): void
    {
        $method = new Method(
            'someMethod',
            new Flag(Flag::FLAG_ABSTRACT, Flag::FLAG_STATIC),
            null,
            null,
            new DocBlock(
                'Some description',
                null,
                [new Tag('throws', InvalidArgumentException::class)]
            ),
            new Type(Type::TYPE_VOID)
        );

        $expected = <<<EOL
    /**
     * Some description
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    abstract public static function someMethod(): void;
EOL;

        $this->assertSame($expected, $this->generator->generate($method));
    }

    public function testMethodWithArgumentsAndDocBlock(): void
    {
        $method = new Method(
            'doSomething',
            null,
            [
                new Argument('name', new Type(Type::TYPE_STRING), new Value()),
                new Argument('email', new Type(Type::TYPE_STRING), new Value()),
            ],
            <<<EOL
\$author = 'Jon Snow';
\$email = 'jon@snow';

return [
    'author' => \$author,
    'email' => \$email, 
];
EOL
            ,
            new DocBlock(
                'Some description',
                null,
                [new Tag('throws', InvalidArgumentException::class)]
            ),
            new Type(Type::TYPE_STRING)
        );

        $expected = <<<EOL
    /**
     * Some description
     *
     * @param string \$name
     * @param string \$email
     *
     * @throws InvalidArgumentException
     *
     * @return string
     */
    public function doSomething(string \$name, string \$email): string
    {
        \$author = 'Jon Snow';
        \$email = 'jon@snow';

        return [
            'author' => \$author,
            'email' => \$email, 
        ];
    }
EOL;

        $this->assertSame($expected, $this->generator->generate($method));
    }
}
