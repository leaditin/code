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
    protected function getScope(): string
    {
        return 'trait';
    }
}
