<?php

namespace Test\Leaditin\Code\Member;

use Leaditin\Code\Import;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Import
 */
final class ImportTest extends TestCase
{
    public function constructorArgumentsDataProvider(): array
    {
        return [
            [
                'fullyQualifiedClassName' => __CLASS__,
                'alias' => null,
            ],
            [
                'fullyQualifiedClassName' => parent::class,
                'alias' => 'ParentClass',
            ],
        ];
    }

    /**
     * @dataProvider constructorArgumentsDataProvider
     *
     * @param string $fullyQualifiedClassName
     * @param null|string $alias
     */
    public function testGetters(string $fullyQualifiedClassName, ?string $alias): void
    {
        $import = new Import($fullyQualifiedClassName, $alias);

        $this->assertSame($fullyQualifiedClassName, $import->fullyQualifiedClassName());
        $this->assertSame($alias, $import->alias());
    }
}
