<?php

namespace Test\Leaditin\Code\Generator;

use Leaditin\Code\DocBlock;
use Leaditin\Code\Flag;
use Leaditin\Code\Generator\ClassGenerator;
use Leaditin\Code\Generator\Factory;
use Leaditin\Code\Import;
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
 * @covers \Leaditin\Code\Generator\ClassGenerator
 */
final class ClassGeneratorTest extends TestCase
{
    /**
     * @var ClassGenerator
     */
    private $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generator = (new Factory())->classGenerator();
    }

    public function testGenerateEmpty(): void
    {
        $this->generator
            ->setName('MyClass')
            ->setNamespace('MyDummyNamespace')
            ->setExtends('MyDummyClass')
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

namespace MyDummyNamespace;

/**
 * Short description
 *
 * Long description
 *
 * @property int \$someInteger
 */
class MyClass extends MyDummyClass
{
}

EOL;
        $this->assertSame($expected, $this->generator->generate());
    }

    public function testGenerateWithConstants(): void
    {
        $this->generator
            ->setName('MyClass')
            ->addConstant(new Constant('CONST_A', 2, new Visibility(Visibility::VISIBILITY_PUBLIC)))
            ->addConstant(new Constant('CONST_B', 3, new Visibility(Visibility::VISIBILITY_PUBLIC)));

        $expected = <<<EOL
<?php

class MyClass
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
            ->setName('MyClass')
            ->addProperty(new Property('name', new Value('Jon'), new Type(Type::TYPE_STRING), new Flag(Flag::FLAG_PROTECTED)))
            ->addProperty(new Property('email', new Value('jon@show'), new Type(Type::TYPE_STRING), new Flag(Flag::FLAG_PROTECTED)));

        $expected = <<<EOL
<?php

class MyClass
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
            ->setName('MyClass')
            ->addMethod(new Method('name', new Flag(Flag::FLAG_PROTECTED), null, 'return \'Jon\';', null, new Type(Type::TYPE_STRING)))
            ->addMethod(new Method('email', new Flag(Flag::FLAG_PROTECTED), null, 'return \'jon@show\';', null, new Type(Type::TYPE_STRING)));

        $expected = <<<EOL
<?php

class MyClass
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

    public function testGenerateWithConstantsAndMethods(): void
    {
        $this->generator
            ->setName('MyClass')
            ->addConstant(new Constant('CONST_A', 2, new Visibility(Visibility::VISIBILITY_PUBLIC)))
            ->addConstant(new Constant('CONST_B', 3, new Visibility(Visibility::VISIBILITY_PUBLIC)))
            ->addMethod(new Method('name', new Flag(Flag::FLAG_PROTECTED), null, 'return \'Jon\';', null, new Type(Type::TYPE_STRING)))
            ->addMethod(new Method('email', new Flag(Flag::FLAG_PROTECTED), null, 'return \'jon@show\';', null, new Type(Type::TYPE_STRING)));

        $expected = <<<EOL
<?php

class MyClass
{
    public const CONST_A = 2;
    public const CONST_B = 3;

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
            ->setName('MyClass')
            ->setNamespace('MyDummyNamespace')
            ->setExtends('\MyDummyClass')
            ->implementInterface('\MyDummyInterface')
            ->useTrait('\MyDummyTrait')
            ->addConstant(new Constant('CONST_A', 2, new Visibility(Visibility::VISIBILITY_PUBLIC)))
            ->addConstant(new Constant('CONST_B', 3, new Visibility(Visibility::VISIBILITY_PUBLIC)))
            ->addProperty(new Property('name', new Value('Jon'), new Type(Type::TYPE_STRING), new Flag(Flag::FLAG_PROTECTED)))
            ->addProperty(new Property('email', new Value('jon@show'), new Type(Type::TYPE_STRING), new Flag(Flag::FLAG_PROTECTED)))
            ->addMethod(new Method('name', new Flag(Flag::FLAG_PROTECTED), null, 'return $this->name;', null, new Type(Type::TYPE_STRING)))
            ->addMethod(new Method('email', new Flag(Flag::FLAG_PROTECTED), null, 'return $this->email;', null, new Type(Type::TYPE_STRING)));

        $expected = <<<EOL
<?php

namespace MyDummyNamespace;

class MyClass extends \MyDummyClass implements \MyDummyInterface
{
    use \MyDummyTrait;

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

    public function testGenerateFinal(): void
    {
        $this->generator
            ->setName('MyClass')
            ->setNamespace('MyNamespace')
            ->setExtends('MyNamespace\MyParentClass')
            ->setFinal(true);

        $expected = <<<EOL
<?php

namespace MyNamespace;

final class MyClass extends MyNamespace\MyParentClass
{
}

EOL;
        $this->assertSame($expected, $this->generator->generate());
    }

    public function testGenerateAbstract(): void
    {
        $this->generator
            ->setName('MyClass')
            ->setNamespace('MyDummyNamespace')
            ->setExtends('\MyDummyClass')
            ->setAbstract(true)
            ->addMethod(new Method('email', new Flag(Flag::FLAG_ABSTRACT), null, null, null, new Type(Type::TYPE_STRING)));

        $expected = <<<EOL
<?php

namespace MyDummyNamespace;

abstract class MyClass extends \MyDummyClass
{
    /**
     * @return string
     */
    abstract public function email(): string;
}

EOL;
        $this->assertSame($expected, $this->generator->generate());
    }

    public function testWithImports(): void
    {
        $this->generator
            ->setName('MyClass')
            ->setNamespace('MyDummyNamespace')
            ->setExtends('MyDummyAlias')
            ->addImport(new Import('MyDummyClass', 'MyDummyAlias'));

        $expected = <<<EOL
<?php

namespace MyDummyNamespace;

use MyDummyClass as MyDummyAlias;

class MyClass extends MyDummyAlias
{
}

EOL;
        $this->assertSame($expected, $this->generator->generate());

    }
}
