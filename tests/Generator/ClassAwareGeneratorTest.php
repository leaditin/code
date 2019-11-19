<?php

namespace Test\Leaditin\Code\Generator;

use Leaditin\Code\DocBlock;
use Leaditin\Code\Generator\ConstantGenerator;
use Leaditin\Code\Generator\ClassAwareGenerator;
use Leaditin\Code\Generator\DocBlockGenerator;
use Leaditin\Code\Generator\MethodGenerator;
use Leaditin\Code\Generator\PropertyGenerator;
use Leaditin\Code\Member\Constant;
use Leaditin\Code\Member\Method;
use Leaditin\Code\Member\Property;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Generator\ClassAwareGenerator
 */
final class ClassAwareGeneratorTest extends TestCase
{
    /**
     * @var ClassAwareGenerator
     */
    private $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generator = $this->getMockForAbstractClass(
            ClassAwareGenerator::class,
            [
                $this->createMock(ConstantGenerator::class),
                $this->createMock(DocBlockGenerator::class),
                $this->createMock(MethodGenerator::class),
                $this->createMock(PropertyGenerator::class),
            ]
        );
    }

    public function testSetName(): void
    {
        $generator = clone $this->generator;
        $generator->setName($this->anything()->toString());

        $this->assertNotEquals($this->generator, $generator);
    }

    public function testSetNamespace(): void
    {
        $generator = clone $this->generator;
        $generator->setNamespace($this->anything()->toString());

        $this->assertNotEquals($this->generator, $generator);
    }

    public function testSetExtends(): void
    {
        $generator = clone $this->generator;
        $generator->setExtends($this->anything()->toString());

        $this->assertNotEquals($this->generator, $generator);
    }

    public function testSetDocBlock(): void
    {
        $generator = clone $this->generator;
        $generator->setDocBlock($this->createMock(DocBlock::class));

        $this->assertNotEquals($this->generator, $generator);
    }

    public function testAddConstant(): void
    {
        $generator = clone $this->generator;
        $generator->addConstant($this->createMock(Constant::class));

        $this->assertNotEquals($this->generator, $generator);
    }

    public function testAddProperty(): void
    {
        $generator = clone $this->generator;
        $generator->addProperty($this->createMock(Property::class));

        $this->assertNotEquals($this->generator, $generator);
    }

    public function testAddMethod(): void
    {
        $generator = clone $this->generator;
        $generator->addMethod($this->createMock(Method::class));

        $this->assertNotEquals($this->generator, $generator);
    }
}
