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
     * @inheritDoc
     */
    protected function scope(): string
    {
        return 'trait';
    }

    /**
     * @inheritDoc
     */
    protected function generateScope(): string
    {
        return $this->generateLine('trait ' . $this->name . $this->generateInheritance()) . $this->generateLine('{');
    }
}
