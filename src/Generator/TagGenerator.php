<?php

namespace Leaditin\Code\Generator;

use Leaditin\Code\Tag;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class TagGenerator extends Generator
{
    /**
     * @param Tag $tag
     *
     * @return string
     */
    public function generate(Tag $tag): string
    {
        return trim("@{$tag->name()} {$tag->value()} {$tag->description()}");
    }
}
