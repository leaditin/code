<?php

namespace Leaditin\Code\Generator;

use Leaditin\Code\DocBlock;
use Leaditin\Code\Member\Constant;
use Leaditin\Code\Member\Method;
use Leaditin\Code\Member\Property;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
abstract class ClassAwareGenerator extends Generator
{
    /**
     * @var ConstantGenerator
     */
    protected $constantGenerator;

    /**
     * @var DocBlockGenerator
     */
    protected $docBlockGenerator;

    /**
     * @var MethodGenerator
     */
    protected $methodGenerator;

    /**
     * @var PropertyGenerator
     */
    protected $propertyGenerator;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var null|string
     */
    protected $namespace;

    /**
     * @var null|string
     */
    protected $extends;

    /**
     * @var null|DocBlock
     */
    protected $docBlock;

    /**
     * @var Constant[]
     */
    protected $constants = [];

    /**
     * @var Property[]
     */
    protected $properties = [];

    /**
     * @var Method[]
     */
    protected $methods = [];

    /**
     * @param ConstantGenerator $constantGenerator
     * @param DocBlockGenerator $docBlockGenerator
     * @param MethodGenerator $methodGenerator
     * @param PropertyGenerator $propertyGenerator
     */
    public function __construct(
        ConstantGenerator $constantGenerator,
        DocBlockGenerator $docBlockGenerator,
        MethodGenerator $methodGenerator,
        PropertyGenerator $propertyGenerator
    ) {
        $this->constantGenerator = $constantGenerator;
        $this->docBlockGenerator = $docBlockGenerator;
        $this->methodGenerator = $methodGenerator;
        $this->propertyGenerator = $propertyGenerator;
    }

    /**
     * @param string $name
     *
     * @return static
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param null|string $namespace
     *
     * @return static
     */
    public function setNamespace(?string $namespace): self
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * @param null|string $extends
     *
     * @return static
     */
    public function setExtends(?string $extends): self
    {
        $this->extends = $extends;

        return $this;
    }

    /**
     * @param null|DocBlock $docBlock
     *
     * @return static
     */
    public function setDocBlock(?DocBlock $docBlock): self
    {
        $this->docBlock = $docBlock;

        return $this;
    }

    /**
     * @param Constant $constant
     *
     * @return static
     */
    public function addConstant(Constant $constant): self
    {
        $this->constants[$constant->name()] = $constant;

        return $this;
    }

    /**
     * @param Property $property
     *
     * @return static
     */
    public function addProperty(Property $property): self
    {
        $this->properties[$property->name()] = $property;

        return $this;
    }

    /**
     * @param Method $method
     *
     * @return static
     */
    public function addMethod(Method $method): self
    {
        $method->setScope($this->getScope());
        $this->methods[$method->name()] = $method;

        return $this;
    }

    /**
     * @return string
     */
    abstract protected function getScope(): string;

    /**
     * @return string
     */
    protected function generateHead(): string
    {
        $output = $this->generateLine('<?php', null, 1);

        if ($this->namespace !== null) {
            $output .= $this->generateLine('namespace ' . ltrim($this->namespace, '\\') . ';', null, 1);
        }

        if ($this->docBlock !== null) {
            $output .= $this->generateLine($this->docBlockGenerator->generate($this->docBlock));
        }

        return $output;
    }

    /**
     * @return string
     */
    protected function generateFoot(): string
    {
        return $this->generateLine('}');
    }

    /**
     * @return string
     */
    protected function generateConstants(): string
    {
        $lines = [];

        foreach ($this->constants as $constant) {
            $lines[] = $this->generateLine($this->constantGenerator->generate($constant));
        }

        return implode('', $lines);
    }

    /**
     * @return string
     */
    protected function generateProperties(): string
    {
        $output = '';

        if ($this->constants !== [] && ($this->properties !== [] || $this->methods !== [])) {
            $output .= $this->generateLine('', 0);
        }

        $lines = [];
        foreach ($this->properties as $property) {
            $lines[] = $this->generateLine($this->propertyGenerator->generate($property));
        }

        $output .= implode($this->endOfLine, $lines);

        return $output;
    }

    /**
     * @return string
     */
    protected function generateMethods(): string
    {
        $output = '';

        if ($this->methods !== [] && ($this->constants !== [] || $this->properties !== [])) {
            $output .= $this->generateLine('', 0);
        }

        $lines = [];
        foreach ($this->methods as $method) {
            $lines[] = $this->generateLine($this->methodGenerator->generate($method));
        }

        $output .= implode($this->endOfLine, $lines);

        return $output;
    }
}
