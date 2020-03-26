<?php

namespace Leaditin\Code\Generator;

use Leaditin\Code\Member\Constant;
use Leaditin\Code\Value;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class ConstantGenerator extends MemberGenerator
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
     * @param DocBlockGenerator $docBlockGenerator
     * @param TypeGenerator $typeGenerator
     * @param ValueGenerator $valueGenerator
     * @param VisibilityGenerator $visibilityGenerator
     */
    public function __construct(
        DocBlockGenerator $docBlockGenerator,
        TypeGenerator $typeGenerator,
        ValueGenerator $valueGenerator,
        VisibilityGenerator $visibilityGenerator
    ) {
        parent::__construct($docBlockGenerator, $typeGenerator, $visibilityGenerator);

        $this->valueGenerator = $valueGenerator;
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
            static::END_OF_LINE
        );
    }
}
