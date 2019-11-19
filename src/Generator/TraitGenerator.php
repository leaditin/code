<?php

namespace Leaditin\Code\Generator;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class TraitGenerator extends ClassAwareGenerator
{
    /**
     * @return string
     */
    public function generate(): string
    {
        $output = $this->generateHead();

        $output .= $this->generateLine('trait ' . $this->name . ($this->extends !== null ? ' extends \\' . ltrim($this->extends, '\\') : ''));
        $output .= $this->generateLine('{');

        $output .= $this->generateConstants();
        $output .= $this->generateProperties();
        $output .= $this->generateMethods();

        $output .= $this->generateFoot();

        return $output;
    }
}
