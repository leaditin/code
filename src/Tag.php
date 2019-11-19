<?php

namespace Leaditin\Code;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class Tag
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var null|string
     */
    protected $description;

    /**
     * @param string $name
     * @param string $value
     * @param null|string $description
     */
    public function __construct(string $name, string $value, string $description = null)
    {
        $this->name = $name;
        $this->value = $value;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @return null|string
     */
    public function description(): ?string
    {
        return $this->description;
    }
}
