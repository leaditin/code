<?php

namespace Leaditin\Code;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class Import
{
    /**
     * @var string
     */
    protected $fullyQualifiedClassName;

    /**
     * @var null|string
     */
    protected $alias;

    /**
     * @param string $fullyQualifiedClassName
     * @param null|string $alias
     */
    public function __construct(string $fullyQualifiedClassName, string $alias = null)
    {
        $this->fullyQualifiedClassName = $fullyQualifiedClassName;
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function fullyQualifiedClassName(): string
    {
        return $this->fullyQualifiedClassName;
    }

    /**
     * @return null|string
     */
    public function alias(): ?string
    {
        return $this->alias;
    }
}
