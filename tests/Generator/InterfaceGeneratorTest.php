<?php

namespace Test\Leaditin\Code\Generator;

use Leaditin\Code\DocBlock;
use Leaditin\Code\Flag;
use Leaditin\Code\Generator\Factory;
use Leaditin\Code\Generator\TraitGenerator;
use Leaditin\Code\Member\Constant;
use Leaditin\Code\Member\Method;
use Leaditin\Code\Tag;
use Leaditin\Code\Type;
use Leaditin\Code\Visibility;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Generator\Generator
 * @covers \Leaditin\Code\Generator\ClassAwareGenerator
 * @covers \Leaditin\Code\Generator\InterfaceGenerator
 */
final class InterfaceGeneratorTest extends TestCase
{
    /**
     * @var TraitGenerator
     */
    private $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generator = (new Factory())->interfaceGenerator();
    }

    public function testGenerateEmpty(): void
    {
        $this->generator
            ->setName('MyInterface')
            ->setNamespace('My\Dummy\Namespace')
            ->setExtends('My\Dummy\Interface')
            ->setDocBlock(
                new DocBlock(
                    'Short description',
                    'Long description',
                    [
                        new Tag('author', 'Code Generator')
                    ]
                )
            );

        $expected = <<<EOL
<?php

namespace My\\Dummy\\Namespace;

/**
 * Short description
 *
 * Long description
 *
 * @author Code Generator
 */
interface MyInterface extends \My\Dummy\Interface
{
}

EOL;
        $this->assertSame($expected, $this->generator->generate());
    }

    public function testGenerateWithConstants(): void
    {
        $this->generator
            ->setName('MyInterface')
            ->addConstant(new Constant('CONST_A', 2, new Visibility(Visibility::VISIBILITY_PUBLIC)))
            ->addConstant(new Constant('CONST_B', 3, new Visibility(Visibility::VISIBILITY_PUBLIC)));

        $expected = <<<EOL
<?php

interface MyInterface
{
    public const CONST_A = 2;
    public const CONST_B = 3;
}

EOL;

        $this->assertSame($expected, $this->generator->generate());
    }

    public function testGenerateWithMethods(): void
    {
        $this->generator
            ->setName('MyInterface')
            ->addMethod(new Method('name', new Flag(Flag::FLAG_PROTECTED), null, null, null, new Type(Type::TYPE_STRING)))
            ->addMethod(new Method('email', new Flag(Flag::FLAG_PROTECTED), null, null, null, new Type(Type::TYPE_STRING, true)));

        $expected = <<<EOL
<?php

interface MyInterface
{
    /**
     * @return string
     */
    protected function name(): string;

    /**
     * @return null|string
     */
    protected function email(): ?string;
}

EOL;

        $this->assertSame($expected, $this->generator->generate());
    }

    public function testGenerate(): void
    {
        $this->generator
            ->setName('MyInterface')
            ->setNamespace('My\Dummy\Namespace')
            ->setExtends('My\Dummy\Interface')
            ->addConstant(new Constant('CONST_A', 2, new Visibility(Visibility::VISIBILITY_PUBLIC)))
            ->addConstant(new Constant('CONST_B', 3, new Visibility(Visibility::VISIBILITY_PUBLIC)))
            ->addMethod(new Method('name', new Flag(Flag::FLAG_PROTECTED), null, null, null, new Type(Type::TYPE_STRING)))
            ->addMethod(new Method('email', new Flag(Flag::FLAG_PROTECTED), null, null, null, new Type(Type::TYPE_STRING)));

        $expected = <<<EOL
<?php

namespace My\Dummy\Namespace;

interface MyInterface extends \My\Dummy\Interface
{
    public const CONST_A = 2;
    public const CONST_B = 3;

    /**
     * @return string
     */
    protected function name(): string;

    /**
     * @return string
     */
    protected function email(): string;
}

EOL;
        $this->assertSame($expected, $this->generator->generate());
    }
}
