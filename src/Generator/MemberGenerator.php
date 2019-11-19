<?php

namespace Leaditin\Code\Generator;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
abstract class MemberGenerator extends Generator
{
    /**
     * @var DocBlockGenerator
     */
    protected $docBlockGenerator;

    /**
     * @var TypeGenerator
     */
    protected $typeGenerator;

    /**
     * @var VisibilityGenerator
     */
    protected $visibilityGenerator;

    /**
     * @param DocBlockGenerator $docBlockGenerator
     * @param TypeGenerator $typeGenerator
     * @param VisibilityGenerator $visibilityGenerator
     */
    public function __construct(
        DocBlockGenerator $docBlockGenerator,
        TypeGenerator $typeGenerator,
        VisibilityGenerator $visibilityGenerator
    ) {
        $this->docBlockGenerator = $docBlockGenerator;
        $this->typeGenerator = $typeGenerator;
        $this->visibilityGenerator = $visibilityGenerator;

        $this->setDepth(1);
        $this->docBlockGenerator->setDepth(1);
    }
}
