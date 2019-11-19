<?php

namespace Leaditin\Code\Generator;

use Leaditin\Code\Member\Constant;
use Leaditin\Code\Value;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class ConstantGenerator extends Generator
{
    /**
     * @var ValueGenerator
     */
    protected $valueGenerator;

    /**
     * @var VisibilityGenerator
     */
    protected $visibilityGenerator;

    /**
     * @param ValueGenerator $valueGenerator
     * @param VisibilityGenerator $visibilityGenerator
     */
    public function __construct(ValueGenerator $valueGenerator, VisibilityGenerator $visibilityGenerator)
    {
        $this->valueGenerator = $valueGenerator;
        $this->visibilityGenerator = $visibilityGenerator;

        $this->setDepth(1);
    }

    /**
     * @param Constant $constant
     *
     * @return string
     */
    public function generate(Constant $constant): string
    {
        return rtrim(
            $this->generateLine(
                sprintf(
                    '%s const %s = %s;',
                    $this->visibilityGenerator->generate($constant->visibility()),
                    $constant->name(),
                    $this->valueGenerator->generate($constant->value() instanceof Value ? $constant->value() : $constant)
                )
            ),
            $this->endOfLine
        );
    }
}
