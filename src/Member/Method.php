<?php

namespace Leaditin\Code\Member;

use InvalidArgumentException;
use Leaditin\Code\Argument;
use Leaditin\Code\DocBlock;
use Leaditin\Code\Flag;
use Leaditin\Code\Type;
use Leaditin\Code\Visibility;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class Method
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var Flag
     */
    protected $flag;

    /**
     * @var Argument[]
     */
    protected $arguments;

    /**
     * @var null|string
     */
    protected $body;

    /**
     * @var null|DocBlock
     */
    protected $docBlock;

    /**
     * @var null|Type
     */
    protected $returnType;

    /**
     *
     * @param string $name
     * @param null|Flag $flag
     * @param null|Argument[] $arguments
     * @param null|string $body
     * @param null|DocBlock $docBlock
     * @param null|Type $returnType
     */
    public function __construct(
        string $name,
        Flag $flag = null,
        array $arguments = null,
        string $body = null,
        DocBlock $docBlock = null,
        Type $returnType = null
    ) {
        $this->name = $name;
        $this->setFlag($flag);
        $this->setArguments($arguments ?? []);
        $this->body = $body;
        $this->docBlock = $docBlock;
        $this->returnType = $returnType;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return Argument[]
     */
    public function arguments(): array
    {
        return $this->arguments;
    }

    /**
     * @return null|string
     */
    public function body(): ?string
    {
        return $this->body;
    }

    /**
     * @return null|DocBlock
     */
    public function docBlock(): ?DocBlock
    {
        return $this->docBlock;
    }

    /**
     * @return null|Type
     */
    public function returnType(): ?Type
    {
        return $this->returnType;
    }

    /**
     * @param bool $isAbstract
     */
    public function setAbstract(bool $isAbstract): void
    {
        $isAbstract ? $this->flag->addFlag(Flag::FLAG_ABSTRACT) : $this->flag->removeFlag(Flag::FLAG_ABSTRACT);
    }

    /**
     * @return bool
     */
    public function isAbstract(): bool
    {
        return $this->flag->hasFlag(Flag::FLAG_ABSTRACT);
    }

    /**
     * @param bool $isFinal
     */
    public function setFinal(bool $isFinal): void
    {
        $isFinal ? $this->flag->addFlag(Flag::FLAG_FINAL) : $this->flag->removeFlag(Flag::FLAG_FINAL);
    }

    /**
     * @return bool
     */
    public function isFinal(): bool
    {
        return $this->flag->hasFlag(Flag::FLAG_FINAL);
    }

    /**
     * @param bool $isStatic
     */
    public function setStatic(bool $isStatic): void
    {
        $isStatic ? $this->flag->addFlag(Flag::FLAG_STATIC) : $this->flag->removeFlag(Flag::FLAG_STATIC);
    }

    /**
     * @return bool
     */
    public function isStatic(): bool
    {
        return $this->flag->hasFlag(Flag::FLAG_STATIC);
    }

    /**
     * @return Visibility
     */
    public function visibility(): Visibility
    {
        return Visibility::fromFlag($this->flag);
    }

    /**
     * @param null|Flag $flag
     */
    protected function setFlag(?Flag $flag): void
    {
        if ($flag === null) {
            $flag = new Flag(Flag::FLAG_PUBLIC);
        }

        $this->flag = $flag;
    }

    /**
     * @param Argument[] $arguments
     */
    protected function setArguments(array $arguments): void
    {
        $this->arguments = [];

        foreach ($arguments as $argument) {
            if (!$argument instanceof Argument) {
                throw new InvalidArgumentException(sprintf('Argument must be instance of %s', Argument::class));
            }

            $this->arguments[] = $argument;
        }
    }
}
