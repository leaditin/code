<?php

namespace Leaditin\Code\Generator;

use Leaditin\Code\Argument;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class ArgumentGenerator extends Generator
{
    /**
     * @var TypeGenerator
     */
    protected $typeGenerator;

    /**
     * @var ValueGenerator
     */
    protected $valueGenerator;

    /**
     * @param TypeGenerator $typeGenerator
     * @param ValueGenerator $valueGenerator
     */
    public function __construct(TypeGenerator $typeGenerator, ValueGenerator $valueGenerator)
    {
        $this->typeGenerator = $typeGenerator;
        $this->valueGenerator = $valueGenerator;
    }

    /**
     * @param Argument $argument
     *
     * @return string
     */
    public function generate(Argument $argument): string
    {
        $output = $this->typeGenerator->generate($argument->type()) . ' ';

        if ($argument->isReference() && $argument->type()->isScalar()) {
            $output .= ' &';
        }

        if ($argument->isVariadic()) {
            $output .= ' ...';
        }

        $output .= '$' . $argument->name();

        if ($argument->defaultValue()->value() === null && !$argument->type()->isNullable()) {
            return trim(preg_replace('/\s+/', ' ', $output));
        }

        $output .= ' = ' . $this->valueGenerator->generate($argument->defaultValue());

        return trim(preg_replace('/\s+/', ' ', $output));
    }
}
