<?php

namespace Leaditin\Code;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class DocBlock
{
    /**
     * @var null|string
     */
    protected $shortDescription;

    /**
     * @var null|string
     */
    protected $longDescription;

    /**
     * @var Tag[]
     */
    protected $tags = [];

    /**
     * @param null|string $shortDescription
     * @param null|string $longDescription
     * @param Tag[] $tags
     */
    public function __construct(string $shortDescription = null, string $longDescription = null, array $tags = [])
    {
        $this->shortDescription = $shortDescription;
        $this->longDescription = $longDescription;
        $this->tags = $tags;
    }

    /**
     * @return null|string
     */
    public function shortDescription(): ?string
    {
        return $this->shortDescription;
    }

    /**
     * @return null|string
     */
    public function longDescription(): ?string
    {
        return $this->longDescription;
    }

    /**
     * @return Tag[]
     */
    public function tags(): array
    {
        return $this->tags;
    }
}
