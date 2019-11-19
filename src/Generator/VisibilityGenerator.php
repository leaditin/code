<?php

namespace Leaditin\Code\Generator;

use Leaditin\Code\Visibility;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class VisibilityGenerator extends Generator
{
    /**
     * @param Visibility $visibility
     *
     * @return string
     */
    public function generate(Visibility $visibility): string
    {
        switch ($visibility->visibility()) {
            case Visibility::VISIBILITY_PRIVATE:
                return 'private';
            case Visibility::VISIBILITY_PROTECTED:
                return 'protected';
            case Visibility::VISIBILITY_PUBLIC:
            default:
                return 'public';
        }
    }
}
