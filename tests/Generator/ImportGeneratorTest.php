<?php

namespace Test\Leaditin\Code\Generator;

use Leaditin\Code\Generator\Factory;
use Leaditin\Code\Generator\ImportGenerator;
use Leaditin\Code\Import;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Generator\ImportGenerator
 */
class ImportGeneratorTest extends TestCase
{
    /**
     * @var ImportGenerator
     */
    private $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generator = (new Factory())->importGenerator();
    }

    public function tagDataProvider(): array
    {
        return [
            [
                'import' => new Import('MyNamespace\\MyClass', null),
                'expected' => 'use MyNamespace\\MyClass;'
            ],
            [
                'import' => new Import('\\MyNamespace\\MyClass', 'MyAlias'),
                'expected' => 'use MyNamespace\\MyClass as MyAlias;'
            ],
        ];
    }

    /**
     * @dataProvider tagDataProvider
     *
     * @param Import $import
     * @param string $output
     */
    public function testGenerate(Import $import, string $output): void
    {
        $this->assertSame($output, $this->generator->generate($import));
    }
}
