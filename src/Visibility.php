<?php

namespace Leaditin\Code;

use InvalidArgumentException;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class Visibility
{
    public const VISIBILITY_PUBLIC = 'public';
    public const VISIBILITY_PROTECTED = 'protected';
    public const VISIBILITY_PRIVATE = 'private';

    /**
     * @var string
     */
    protected $visibility;

    /**
     *
     * @param string $visibility
     */
    public function __construct(string $visibility)
    {
        $this->validate($visibility);
        $this->visibility = strtolower($visibility);
    }

    /**
     * @param Flag $flag
     *
     * @return Visibility
     */
    public static function fromFlag(Flag $flag): Visibility
    {
        if ($flag->hasFlag(Flag::FLAG_PRIVATE)) {
            return new Visibility(static::VISIBILITY_PRIVATE);
        }

        if ($flag->hasFlag(Flag::FLAG_PROTECTED)) {
            return new Visibility(static::VISIBILITY_PROTECTED);
        }

        return new Visibility(static::VISIBILITY_PUBLIC);
    }

    /**
     * @return string
     */
    public function visibility(): string
    {
        return $this->visibility;
    }

    /**
     * @param string $visibility
     *
     * @throws InvalidArgumentException
     */
    protected function validate(string $visibility): void
    {
        if (!in_array($visibility, [self::VISIBILITY_PUBLIC, self::VISIBILITY_PROTECTED, self::VISIBILITY_PRIVATE], true)) {
            throw new InvalidArgumentException("Visibility '$visibility' is not valid visibility case.");
        }
    }
}
