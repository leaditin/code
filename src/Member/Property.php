<?php

namespace Leaditin\Code\Member;

use Leaditin\Code\Flag;
use Leaditin\Code\Type;
use Leaditin\Code\Value;
use Leaditin\Code\Visibility;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class Property
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
     * @var Flag
     */
    protected $flag;

    /**
     * @param string $name
     * @param Value $defaultValue
     * @param Type $type
     * @param null|Flag $flag
     */
    public function __construct(string $name, Value $defaultValue, Type $type, Flag $flag = null)
    {
        $this->name = $name;
        $this->defaultValue = $defaultValue;
        $this->type = $type;
        $this->flag = $flag ?? new Flag(Flag::FLAG_PUBLIC);
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return Value
     */
    public function defaultValue(): Value
    {
        return $this->defaultValue;
    }

    /**
     * @return Type
     */
    public function type(): Type
    {
        return $this->type;
    }

    /**
     * @return Visibility
     */
    public function visibility(): Visibility
    {
        return Visibility::fromFlag($this->flag);
    }

    /**
     * @param bool $isStatic
     */
    public function setStatic(bool $isStatic): void
    {
        $isStatic ? $this->flag->addFlag(Flag::FLAG_STATIC) : $this->flag->removeFlag(Flag::FLAG_STATIC);
    }

    /**
     * @return bool
     */
    public function isStatic(): bool
    {
        return $this->flag->hasFlag(Flag::FLAG_STATIC);
    }
}
