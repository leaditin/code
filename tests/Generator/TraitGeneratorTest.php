<?php

namespace Test\Leaditin\Code\Generator;

use Leaditin\Code\DocBlock;
use Leaditin\Code\Flag;
use Leaditin\Code\Generator\Factory;
use Leaditin\Code\Generator\TraitGenerator;
use Leaditin\Code\Member\Constant;
use Leaditin\Code\Member\Method;
use Leaditin\Code\Member\Property;
use Leaditin\Code\Tag;
use Leaditin\Code\Type;
use Leaditin\Code\Value;
use Leaditin\Code\Visibility;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Generator\Generator
 * @covers \Leaditin\Code\Generator\ClassAwareGenerator
 * @covers \Leaditin\Code\Generator\TraitGenerator
 */
final class TraitGeneratorTest extends TestCase
{
    /**
     * @var TraitGenerator
     */
    private $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generator = (new Factory())->traitGenerator();
    }

    public function testGenerateEmpty(): void
    {
        $this->generator
            ->setName('MyTrait')
            ->setNamespace('My\Dummy\Namespace')
            ->setExtends('My\Dummy\Trait')
            ->setDocBlock(
                new DocBlock(
                    'Short description',
                    'Long description',
                    [
                        new Tag('property', 'int $someInteger')
                    ]
                )
            );

        $expected = <<<EOL
<?php

namespace My\Dummy\Namespace;

/**
 * Short description
 *
 * Long description
 *
 * @property int \$someInteger
 */
trait MyTrait extends \My\Dummy\Trait
{
}

EOL;
        $this->assertSame($expected, $this->generator->generate());
    }

    public function testGenerateWithConstants(): void
    {
        $this->generator
            ->setName('MyTrait')
            ->addConstant(new Constant('CONST_A', 2, new Visibility(Visibility::VISIBILITY_PUBLIC)))
            ->addConstant(new Constant('CONST_B', 3, new Visibility(Visibility::VISIBILITY_PUBLIC)));

        $expected = <<<EOL
<?php

trait MyTrait
{
    public const CONST_A = 2;
    public const CONST_B = 3;
}

EOL;

        $this->assertSame($expected, $this->generator->generate());
    }

    public function testGenerateWithProperties(): void
    {
        $this->generator
            ->setName('MyTrait')
            ->addProperty(new Property('name', new Value('Jon'), new Type(Type::TYPE_STRING), new Flag(Flag::FLAG_PROTECTED)))
            ->addProperty(new Property('email', new Value('jon@show'), new Type(Type::TYPE_STRING), new Flag(Flag::FLAG_PROTECTED)));

        $expected = <<<EOL
<?php

trait MyTrait
{
    /**
     * @var string
     */
    protected \$name = 'Jon';

    /**
     * @var string
     */
    protected \$email = 'jon@show';
}

EOL;

        $this->assertSame($expected, $this->generator->generate());
    }

    public function testGenerateWithMethods(): void
    {
        $this->generator
            ->setName('MyTrait')
            ->addMethod(new Method('name', new Flag(Flag::FLAG_PROTECTED), null, 'return \'Jon\';', null, new Type(Type::TYPE_STRING)))
            ->addMethod(new Method('email', new Flag(Flag::FLAG_PROTECTED), null, 'return \'jon@show\';', null, new Type(Type::TYPE_STRING)));

        $expected = <<<EOL
<?php

trait MyTrait
{
    /**
     * @return string
     */
    protected function name(): string
    {
        return 'Jon';
    }

    /**
     * @return string
     */
    protected function email(): string
    {
        return 'jon@show';
    }
}

EOL;

        $this->assertSame($expected, $this->generator->generate());
    }

    public function testGenerate(): void
    {
        $this->generator
            ->setName('MyTrait')
            ->addConstant(new Constant('CONST_A', 2, new Visibility(Visibility::VISIBILITY_PUBLIC)))
            ->addConstant(new Constant('CONST_B', 3, new Visibility(Visibility::VISIBILITY_PUBLIC)))
            ->addProperty(new Property('name', new Value('Jon'), new Type(Type::TYPE_STRING), new Flag(Flag::FLAG_PROTECTED)))
            ->addProperty(new Property('email', new Value('jon@show'), new Type(Type::TYPE_STRING), new Flag(Flag::FLAG_PROTECTED)))
            ->addMethod(new Method('name', new Flag(Flag::FLAG_PROTECTED), null, 'return $this->name;', null, new Type(Type::TYPE_STRING)))
            ->addMethod(new Method('email', new Flag(Flag::FLAG_PROTECTED), null, 'return $this->email;', null, new Type(Type::TYPE_STRING)));

        $expected = <<<EOL
<?php

trait MyTrait
{
    public const CONST_A = 2;
    public const CONST_B = 3;

    /**
     * @var string
     */
    protected \$name = 'Jon';

    /**
     * @var string
     */
    protected \$email = 'jon@show';

    /**
     * @return string
     */
    protected function name(): string
    {
        return \$this->name;
    }

    /**
     * @return string
     */
    protected function email(): string
    {
        return \$this->email;
    }
}

EOL;
        $this->assertSame($expected, $this->generator->generate());
    }
}
