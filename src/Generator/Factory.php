<?php

namespace Leaditin\Code\Generator;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class Factory
{
    /**
     * @return ArgumentGenerator
     */
    public function argumentGenerator(): ArgumentGenerator
    {
        return new ArgumentGenerator(
            $this->typeGenerator(),
            $this->valueGenerator()
        );
    }

    /**
     * @return ConstantGenerator
     */
    public function constantGenerator(): ConstantGenerator
    {
        return new ConstantGenerator(
            $this->docBlockGenerator(),
            $this->typeGenerator(),
            $this->valueGenerator(),
            $this->visibilityGenerator()
        );
    }

    /**
     * @return DocBlockGenerator
     */
    public function docBlockGenerator(): DocBlockGenerator
    {
        return new DocBlockGenerator(
            $this->tagGenerator()
        );
    }

    /**
     * @return MethodGenerator
     */
    public function methodGenerator(): MethodGenerator
    {
        return new MethodGenerator(
            $this->argumentGenerator(),
            $this->docBlockGenerator(),
            $this->typeGenerator(),
            $this->visibilityGenerator()
        );
    }

    /**
     * @return PropertyGenerator
     */
    public function propertyGenerator(): PropertyGenerator
    {
        return new PropertyGenerator(
            $this->docBlockGenerator(),
            $this->typeGenerator(),
            $this->valueGenerator(),
            $this->visibilityGenerator()
        );
    }

    /**
     * @return TagGenerator
     */
    public function tagGenerator(): TagGenerator
    {
        return new TagGenerator();
    }

    /**
     * @return TraitGenerator
     */
    public function traitGenerator(): TraitGenerator
    {
        return new TraitGenerator(
            $this->constantGenerator(),
            $this->docBlockGenerator(),
            $this->methodGenerator(),
            $this->propertyGenerator()
        );
    }

    /**
     * @return TypeGenerator
     */
    public function typeGenerator(): TypeGenerator
    {
        return new TypeGenerator();
    }

    /**
     * @return ValueGenerator
     */
    public function valueGenerator(): ValueGenerator
    {
        return new ValueGenerator();
    }

    /**
     * @return VisibilityGenerator
     */
    public function visibilityGenerator(): VisibilityGenerator
    {
        return new VisibilityGenerator();
    }
}
