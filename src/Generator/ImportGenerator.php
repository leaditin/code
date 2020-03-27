<?php

namespace Leaditin\Code\Generator;

use Leaditin\Code\Import;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class ImportGenerator extends Generator
{
    /**
     * @param Import $import
     *
     * @return string
     */
    public function generate(Import $import): string
    {
        $output = 'use ' . ltrim($import->fullyQualifiedClassName(), '\\');

        if ($import->alias() !== null) {
            $output .= ' as ' . $import->alias();
        }

        $output .= ';';

        return rtrim($this->generateLine($output), static::END_OF_LINE);
    }
}
