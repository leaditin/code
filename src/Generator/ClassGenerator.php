<?php

namespace Leaditin\Code\Generator;

use Leaditin\Code\Flag;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class ClassGenerator extends ClassAwareGenerator
{
    /**
     * @var Flag
     */
    protected $flag;

    /**
     * @var string[]
     */
    protected $interfaces = [];

    /**
     * @var string[]
     */
    protected $traits = [];

    /**
     * @inheritDoc
     */
    public function __construct(
        ConstantGenerator $constantGenerator,
        DocBlockGenerator $docBlockGenerator,
        MethodGenerator $methodGenerator,
        PropertyGenerator $propertyGenerator
    ) {
        parent::__construct($constantGenerator, $docBlockGenerator, $methodGenerator, $propertyGenerator);

        $this->flag = new Flag();
    }

    /**
     * @param bool $isAbstract
     *
     * @return ClassGenerator
     */
    public function setAbstract(bool $isAbstract): self
    {
        $isAbstract ? $this->flag->addFlag(Flag::FLAG_ABSTRACT) : $this->flag->removeFlag(Flag::FLAG_ABSTRACT);

        return $this;
    }

    /**
     * @param bool $isFinal
     *
     * @return static
     */
    public function setFinal(bool $isFinal): self
    {
        $isFinal ? $this->flag->addFlag(Flag::FLAG_FINAL) : $this->flag->removeFlag(Flag::FLAG_FINAL);

        return $this;
    }

    /**
     * @param string $fullyQualifiedInterfaceName
     *
     * @return static
     */
    public function implementInterface(string $fullyQualifiedInterfaceName): self
    {
        $fullyQualifiedInterfaceName = '\\' . ltrim($fullyQualifiedInterfaceName, '\\');

        $this->interfaces[$fullyQualifiedInterfaceName] = $fullyQualifiedInterfaceName;

        return $this;
    }

    /**
     * @param string $fullyQualifiedTraitName
     *
     * @return static
     */
    public function useTrait(string $fullyQualifiedTraitName): self
    {
        $fullyQualifiedTraitName = '\\' . ltrim($fullyQualifiedTraitName, '\\');

        $this->traits[$fullyQualifiedTraitName] = $fullyQualifiedTraitName;

        return $this;
    }

    /**
     * @inheritDoc
     */
    protected function scope(): string
    {
        return 'class';
    }

    /**
     * @inheritDoc
     */
    protected function generateScope(): string
    {
        return $this->generateLine(
            "{$this->generateFlags()} $this->name{$this->generateInheritance()}{$this->generateImplements()}"
        ) . $this->generateLine('{') . $this->generateUses();
    }

    /**
     * @return string
     */
    protected function generateFlags(): string
    {
        if ($this->flag->hasFlag(Flag::FLAG_FINAL)) {
            return 'final class';
        }

        if ($this->flag->hasFlag(Flag::FLAG_ABSTRACT)) {
            return 'abstract class';
        }

        return 'class';
    }

    /**
     * @return string
     */
    protected function generateImplements(): string
    {
        if ($this->interfaces === []) {
            return '';
        }

        return ' implements ' . implode(', ', $this->interfaces);
    }

    /**
     * @return string
     */
    protected function generateUses(): string
    {
        if ($this->traits === []) {
            return '';
        }

        return $this->generateLine('use ' . implode(', ', $this->traits) . ';', 1, 1);
    }
}
