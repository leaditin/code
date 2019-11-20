<?php

namespace Test\Leaditin\Code\Member;

use InvalidArgumentException;
use Leaditin\Code\DocBlock;
use Leaditin\Code\Flag;
use Leaditin\Code\Argument;
use Leaditin\Code\Member\Method;
use Leaditin\Code\Type;
use Leaditin\Code\Visibility;
use PHPUnit\Framework\TestCase;

/**
 * @package Test\Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 *
 * @covers \Leaditin\Code\Member\Method
 */
final class MethodTest extends TestCase
{
    public function constructArgumentsDataProvider(): array
    {
        return [
            [
                'name' => $this->anything()->toString(),
                'flag' => new Flag(Flag::FLAG_PUBLIC),
                'arguments' => null,
                'body' => $this->anything()->toString(),
                'docBlock' => null,
                'returnType' => null,
            ],
            [
                'name' => $this->anything()->toString(),
                'flag' => null,
                'arguments' => [
                    $this->createMock(Argument::class),
                    $this->createMock(Argument::class),
                ],
                'body' => $this->anything()->toString(),
                'docBlock' => $this->createMock(DocBlock::class),
                'returnType' => $this->createMock(Type::class),
            ],

        ];
    }

    /**
     * @dataProvider constructArgumentsDataProvider
     *
     * @param string $name
     * @param null|Flag $flag
     * @param null|array $arguments
     * @param string $body
     * @param null|DocBlock $docBlock
     * @param null|Type $returnType
     */
    public function testGetters(string $name, ?Flag $flag, ?array $arguments, string $body, ?DocBlock $docBlock, ?Type $returnType): void
    {
        $method = new Method($name, $flag, $arguments, $body, $docBlock, $returnType);

        $this->assertSame($name, $method->name());
        $this->assertSame((array)$arguments, $method->arguments());
        $this->assertSame($body, $method->body());
        $this->assertSame($docBlock, $method->docBlock());
        $this->assertSame($returnType, $method->returnType());
    }

    public function testFinalMethod(): void
    {
        $method = new Method($this->anything()->toString());
        $method->setFinal(true);

        $this->assertTrue($method->isFinal());

        $method = new Method($this->anything()->toString(), new Flag(Flag::FLAG_FINAL));
        $this->assertTrue($method->isFinal());

        $method->setFinal(false);
        $this->assertFalse($method->isFinal());
    }

    public function testAbstractMethod(): void
    {
        $method = new Method($this->anything()->toString());
        $method->setAbstract(true);

        $this->assertTrue($method->isAbstract());

        $method = new Method($this->anything()->toString(), new Flag(Flag::FLAG_ABSTRACT));
        $this->assertTrue($method->isAbstract());

        $method->setAbstract(false);
        $this->assertFalse($method->isAbstract());
    }

    public function testStaticMethod(): void
    {
        $method = new Method($this->anything()->toString());
        $method->setStatic(true);

        $this->assertTrue($method->isStatic());

        $method = new Method($this->anything()->toString(), new Flag(Flag::FLAG_STATIC));
        $this->assertTrue($method->isStatic());

        $method->setStatic(false);
        $this->assertFalse($method->isStatic());
    }

    public function visibilityDataProvider(): array
    {
        return [
            [
                'flag' => null,
                'visibility' => Visibility::VISIBILITY_PUBLIC,
            ], [
                'flag' => new Flag(Flag::FLAG_PUBLIC),
                'visibility' => Visibility::VISIBILITY_PUBLIC,
            ],
            [
                'flag' => new Flag(Flag::FLAG_PROTECTED),
                'visibility' => Visibility::VISIBILITY_PROTECTED,
            ],
            [
                'flag' => new Flag(Flag::FLAG_PRIVATE),
                'visibility' => Visibility::VISIBILITY_PRIVATE,
            ],
        ];
    }

    /**
     * @dataProvider visibilityDataProvider
     *
     * @param null|Flag $flag
     * @param string $visibility
     */
    public function testVisibility(?Flag $flag, string $visibility): void
    {
        $method = new Method($this->anything()->toString(), $flag);

        $this->assertSame($visibility, $method->visibility()->visibility());
    }

    public function testInvalidArgumentThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Argument must be instance of %s', Argument::class));

        new Method($this->anything()->toString(), null, [$this->anything()->toString()]);
    }

    public function scopeDataProvider(): array
    {
        return [
            [Method::SCOPE_CLASS],
            [Method::SCOPE_INTERFACE],
            [Method::SCOPE_TRAIT],
        ];
    }

    /**
     * @dataProvider scopeDataProvider
     * 
     * @param string $scope
     */
    public function testScope(string $scope): void
    {
        $method = new Method($this->anything()->toString());
        $method->setScope($scope);

        $this->assertSame($scope, $method->scope());
    }
}
