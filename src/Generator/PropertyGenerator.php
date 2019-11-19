<?php

namespace Leaditin\Code\Generator;

use Leaditin\Code\DocBlock;
use Leaditin\Code\Member\Property;
use Leaditin\Code\Tag;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class PropertyGenerator extends Generator
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
        $this->docBlockGenerator = $docBlockGenerator;
        $this->typeGenerator = $typeGenerator;
        $this->valueGenerator = $valueGenerator;
        $this->visibilityGenerator = $visibilityGenerator;

        $this->setDepth(1);
        $this->docBlockGenerator->setDepth(1);
    }

    /**
     * @param Property $property
     *
     * @return string
     */
    public function generate(Property $property): string
    {
        $output = $this->generateLine(
            $this->docBlockGenerator->generate(
                new DocBlock(
                    null,
                    null,
                    [
                        new Tag('var', $this->typeGenerator->generate($property->type()))
                    ]
                )
            ),
            0
        );

        $line = $this->visibilityGenerator->generate($property->visibility());

        if ($property->isStatic()) {
            $line .= ' static';
        }

        $line .= ' $' . $property->name();

        if ($property->defaultValue()->value() !== null) {
            $line .= ' = ' . $this->valueGenerator->generate($property->defaultValue());
        }

        $line .= ';';

        $output .= $this->generateLine($line);

        return rtrim($output, $this->endOfLine);
    }
}
