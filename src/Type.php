<?php

namespace Leaditin\Code;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class Type
{
    public const TYPE_BOOL = 'bool';
    public const TYPE_INT = 'int';
    public const TYPE_FLOAT = 'float';
    public const TYPE_STRING = 'string';
    public const TYPE_ARRAY = 'array';
    public const TYPE_CALLABLE = 'callable';
    public const TYPE_MIXED = 'mixed';
    public const TYPE_VOID = 'void';

    /**
     * @var string
     */
    protected $type;

    /**
     * @var bool
     */
    protected $isNullable;

    /**
     * @param string $type
     * @param bool $isNullable
     */
    public function __construct(string $type, bool $isNullable = false)
    {
        $this->type = $type;
        $this->isNullable = $isNullable;
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isNullable(): bool
    {
        return $this->isNullable;
    }

    /**
     * @return bool
     */
    public function isScalar(): bool
    {
        return in_array(
            $this->type,
            [
                self::TYPE_BOOL,
                self::TYPE_INT,
                self::TYPE_STRING,
                self::TYPE_FLOAT,
                self::TYPE_ARRAY,
            ],
            false
        );
    }
}
