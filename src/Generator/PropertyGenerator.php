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
class PropertyGenerator extends MemberGenerator
{
    /**
     * @var ValueGenerator
     */
    protected $valueGenerator;

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
