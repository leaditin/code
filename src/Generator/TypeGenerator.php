<?php

namespace Leaditin\Code\Generator;

use Leaditin\Code\Type;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class TypeGenerator extends Generator
{
    /**
     * @param Type $type
     *
     * @return string
     */
    public function generate(Type $type): string
    {
        if ($type->type() === Type::TYPE_MIXED) {
            return '';
        }

        if ($type->type() === Type::TYPE_VOID) {
            return 'void';
        }

        $nullable = $type->isNullable() ? '?' : '';

        if ($type->type() === Type::TYPE_CALLABLE || $type->isScalar()) {
            return $nullable . $type->type();
        }

        return $nullable . trim($type->type());
    }
}
