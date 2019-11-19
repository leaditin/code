<?php

namespace Leaditin\Code;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class Flag
{
    public const FLAG_ABSTRACT = 0x01;
    public const FLAG_FINAL = 0x02;
    public const FLAG_STATIC = 0x04;
    public const FLAG_PUBLIC = 0x10;
    public const FLAG_PROTECTED = 0x20;
    public const FLAG_PRIVATE = 0x40;

    /**
     * @var int
     */
    protected $flags;

    /**
     * @param int ...$flags
     */
    public function __construct(int ...$flags)
    {
        $this->setFlags($flags);
    }

    /**
     * @param int $flag
     */
    public function addFlag(int $flag): void
    {
        $this->setFlags($this->flags | $flag);
    }

    /**
     * @param int $flag
     */
    public function removeFlag(int $flag): void
    {
        $this->setFlags($this->flags & ~$flag);
    }

    /**
     * @param int $flag
     *
     * @return bool
     */
    public function hasFlag(int $flag): bool
    {
        return (bool)($this->flags & $flag);
    }

    /**
     * @param array|int $flags
     */
    protected function setFlags($flags): void
    {
        if (is_array($flags)) {
            $flagsArray = $flags;
            $flags = 0x00;
            foreach ($flagsArray as $flag) {
                $flags |= $flag;
            }
        }

        $this->flags = $flags;
    }
}
