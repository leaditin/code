<?php

namespace Leaditin\Code\Member;

use Leaditin\Code\Type;
use Leaditin\Code\Value;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class Argument
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var Type
     */
    protected $type;

    /**
     * @var Value
     */
    protected $defaultValue;

    /**
     * @var bool
     */
    protected $isReference;

    /**
     * @var bool
     */
    protected $isVariadic;

    /**
     * @param string $name
     * @param Type $type
     * @param Value $defaultValue
     * @param bool $isReference
     * @param bool $isVariadic
     */
    public function __construct(string $name, Type $type, Value $defaultValue, bool $isReference = false, bool $isVariadic = false)
    {
        $this->name = $name;
        $this->type = $type;
        $this->defaultValue = $defaultValue;
        $this->isReference = $isReference;
        $this->isVariadic = $isVariadic;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return Type
     */
    public function type(): Type
    {
        return $this->type;
    }

    /**
     * @return Value
     */
    public function defaultValue(): Value
    {
        return $this->defaultValue;
    }

    /**
     * @return bool
     */
    public function isReference(): bool
    {
        return $this->isReference;
    }

    /**
     * @return bool
     */
    public function isVariadic(): bool
    {
        return $this->isVariadic;
    }
}
