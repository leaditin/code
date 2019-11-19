<?php

namespace Leaditin\Code;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class Value
{
    /**
     * @var null|mixed
     */
    protected $value;

    /**
     * @param null|mixed $value
     */
    public function __construct($value = null)
    {
        $this->value = $value;
    }

    /**
     * @return null|mixed
     */
    public function value()
    {
        return $this->value;
    }
}
