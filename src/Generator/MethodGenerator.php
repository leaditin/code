<?php

namespace Leaditin\Code\Generator;

use Leaditin\Code\DocBlock;
use Leaditin\Code\Member\Method;
use Leaditin\Code\Tag;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class MethodGenerator extends MemberGenerator
{
    /**
     * @var ArgumentGenerator
     */
    protected $argumentGenerator;

    /**
     * @param ArgumentGenerator $argumentGenerator
     * @param DocBlockGenerator $docBlockGenerator
     * @param TypeGenerator $typeGenerator
     * @param VisibilityGenerator $visibilityGenerator
     */
    public function __construct(
        ArgumentGenerator $argumentGenerator,
        DocBlockGenerator $docBlockGenerator,
        TypeGenerator $typeGenerator,
        VisibilityGenerator $visibilityGenerator
    ) {
        parent::__construct($docBlockGenerator, $typeGenerator, $visibilityGenerator);

        $this->argumentGenerator = $argumentGenerator;
    }

    /**
     * @param Method $method
     *
     * @return string
     */
    public function generate(Method $method): string
    {
        $output = $this->generateLine($this->docBlockGenerator->generate($this->generateDocBlock($method)), 0);

        $line = '';
        if ($method->isAbstract()) {
            $line .= 'abstract ';
        } elseif ($method->isFinal()) {
            $line .= 'final ';
        }

        $line .= $this->visibilityGenerator->generate($method->visibility());

        if ($method->isStatic()) {
            $line .= ' static';
        }

        $line .= ' function ' . $method->name() . '(';

        $arguments = [];
        foreach ($method->arguments() as $argument) {
            $arguments[] = $this->argumentGenerator->generate($argument);
        }
        $line .= implode(', ', $arguments);

        $line .= ')';

        if ($method->returnType() !== null) {
            $line .= ': ' . $this->typeGenerator->generate($method->returnType());
        }

        if ($method->isAbstract()) {
            $output .= $this->generateLine($line . ';');

            return rtrim($output, $this->endOfLine);
        }

        $output .= $this->generateLine($line);
        $output .= $this->generateLine('{');

        if ($method->body() !== null) {
            $output .= $this->generateLine(
                preg_replace(
                    '#^((?![a-zA-Z0-9_-]+;).+?)$#m',
                    '$1',
                    trim($method->body())
                ),
                2
            );
        }

        $output .= $this->generateLine('}');

        return rtrim($output, $this->endOfLine);
    }

    /**
     * @param Method $method
     *
     * @return DocBlock
     */
    protected function generateDocBlock(Method $method): DocBlock
    {
        $docblock = '';
        $shortDescription = null;
        $longDescription = null;
        $tags = [];

        if ($method->docBlock() !== null) {
            $docblock = $this->docBlockGenerator->generate($method->docBlock());
            $shortDescription = $method->docBlock()->shortDescription();
            $longDescription = $method->docBlock()->longDescription();
            $tags = $method->docBlock()->tags();
        }

        foreach ($method->arguments() as $argument) {
            $comment = '@property ' . $this->argumentGenerator->generate($argument);

            if (strpos($docblock, $comment) === false) {
                $tags[] = new Tag('property', $this->argumentGenerator->generate($argument));
            }
        }

        if ($method->returnType() !== null && strpos($docblock, '@return') === false) {
            $tags[] = new Tag('return', ($method->returnType()->isNullable() ? 'null|' : '') . $method->returnType()->type());
        }

        return new DocBlock($shortDescription, $longDescription, $tags);
    }
}
