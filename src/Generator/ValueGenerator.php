<?php

namespace Leaditin\Code\Generator;

use Leaditin\Code\Value;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class ValueGenerator extends Generator
{
    /**
     * @param Value $value
     *
     * @return string
     */
    public function generate(Value $value): string
    {
        if (is_iterable($value->value())) {
            $val = $value->value();
            array_walk($val, function (&$val) {
                if (is_string($val) || is_bool($val)) {
                    $val = $this->generateScalar($val);

                    return $val;
                }

                return $val;
            });

            return '[' . implode(', ', $val) . ']';
        }

        if ($value->value() !== null && is_object($value->value())) {
            return get_class($value->value());
        }

        return $this->generateScalar($value->value());
    }

    /**
     * @param $value
     *
     * @return string
     */
    protected function generateScalar($value): string
    {
        if ($value === null) {
            return 'null';
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (is_numeric($value)) {
            return (string)$value;
        }

        return "'" . preg_quote($value, '\'') . "'";
    }
}
