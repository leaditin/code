<?php

namespace Leaditin\Code\Generator;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
abstract class Generator
{
    /**
     * @var string
     */
    protected $indentation = '    ';

    /**
     * @var string
     */
    protected $endOfLine = PHP_EOL;

    /**
     * @var int
     */
    protected $depth = 0;

    /**
     * @param int $depth
     *
     * @return static
     */
    public function setDepth(int $depth): self
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * @param string $text
     * @param null|int $numberOfIndentationBefore
     * @param int $numberOfEmptyLinesAfter
     *
     * @return string
     */
    protected function generateLine(string $text, int $numberOfIndentationBefore = null, int $numberOfEmptyLinesAfter = 0): string
    {
        return str_repeat($this->indentation, $numberOfIndentationBefore ?? $this->depth)
            . $text
            . str_repeat($this->endOfLine, ++$numberOfEmptyLinesAfter);
    }
}
