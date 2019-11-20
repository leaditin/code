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
    protected function getScope(): string
    {
        return 'interface';
    }

    /**
     * @inheritDoc
     */
    protected function generateProperties(): string
    {
        return '';
    }
}
