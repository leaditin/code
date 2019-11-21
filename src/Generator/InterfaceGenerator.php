<?php

namespace Leaditin\Code\Generator;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class InterfaceGenerator extends ClassAwareGenerator
{
    /**
     * @inheritDoc
     */
    protected function scope(): string
    {
        return 'interface';
    }

    /**
     * @inheritDoc
     */
    protected function generateScope(): string
    {
        return $this->generateLine('interface ' . $this->name . $this->generateInheritance()). $this->generateLine('{');
    }

    /**
     * @inheritDoc
     */
    protected function generateProperties(): string
    {
        return '';
    }
}
