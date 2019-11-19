<?php

namespace Leaditin\Code\Member;

use Leaditin\Code\Value;
use Leaditin\Code\Visibility;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class Constant extends Value
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var Visibility
     */
    protected $visibility;

    /**
     * @param string $name
     * @param mixed $value
     * @param Visibility $visibility
     */
    public function __construct(string $name, $value, Visibility $visibility)
    {
        $this->name = $name;
        $this->visibility = $visibility;

        parent::__construct($value);
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return Visibility
     */
    public function visibility(): Visibility
    {
        return $this->visibility;
    }
}
