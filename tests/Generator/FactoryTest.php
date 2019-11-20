<?php

namespace Test\Leaditin\Code\Generator;

use Leaditin\Code\Generator\ArgumentGenerator;
use Leaditin\Code\Generator\ClassGenerator;
use Leaditin\Code\Generator\ConstantGenerator;
use Leaditin\Code\Generator\DocBlockGenerator;
use Leaditin\Code\Generator\Factory;
use Leaditin\Code\Generator\InterfaceGenerator;
use Leaditin\Code\Generator\MethodGenerator;
use Leaditin\Code\Generator\PropertyGenerator;
use Leaditin\Code\Generator\TagGenerator;
use Leaditin\Code\Generator\TraitGenerator;
use Leaditin\Code\Generator\TypeGenerator;
use Leaditin\Code\Generator\ValueGenerator;
use Leaditin\Code\Generator\VisibilityGenerator;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Generator\Factory
 */
final class FactoryTest extends TestCase
{
    /**
     * @var Factory
     */
    private $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = new Factory();
    }

    public function generatorNameDataProvider(): array
    {
        return [
            [
                'methodName' => 'argumentGenerator',
                'expected' => ArgumentGenerator::class,
            ],
            [
                'methodName' => 'classGenerator',
                'expected' => ClassGenerator::class,
            ],
            [
                'methodName' => 'constantGenerator',
                'expected' => ConstantGenerator::class,
            ],
            [
                'methodName' => 'docBlockGenerator',
                'expected' => DocBlockGenerator::class,
            ],[
                'methodName' => 'interfaceGenerator',
                'expected' => InterfaceGenerator::class,
            ],
            [
                'methodName' => 'methodGenerator',
                'expected' => MethodGenerator::class,
            ],
            [
                'methodName' => 'propertyGenerator',
                'expected' => PropertyGenerator::class,
            ],
            [
                'methodName' => 'tagGenerator',
                'expected' => TagGenerator::class,
            ],
            [
                'methodName' => 'traitGenerator',
                'expected' => TraitGenerator::class,
            ],
            [
                'methodName' => 'typeGenerator',
                'expected' => TypeGenerator::class,
            ],
            [
                'methodName' => 'valueGenerator',
                'expected' => ValueGenerator::class,
            ],
            [
                'methodName' => 'visibilityGenerator',
                'expected' => VisibilityGenerator::class,
            ],
        ];
    }

    /**
     * @dataProvider generatorNameDataProvider
     *
     * @param string $methodName
     * @param string $expected
     */
    public function testArgumentGenerator(string $methodName, string $expected): void
    {
        $this->assertInstanceOf($expected, $this->factory->$methodName());
    }
}
