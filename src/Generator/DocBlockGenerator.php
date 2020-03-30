<?php

namespace Leaditin\Code\Generator;

use Leaditin\Code\DocBlock;

/**
 * @package Leaditin\Code
 * @author Igor Vuckovic <igor@vuckovic.biz>
 * @license MIT
 */
class DocBlockGenerator extends Generator
{
    /**
     * @var TagGenerator
     */
    protected $tagGenerator;

    /**
     * @param TagGenerator $tagGenerator
     */
    public function __construct(TagGenerator $tagGenerator)
    {
        $this->tagGenerator = $tagGenerator;
    }

    /**
     * @param DocBlock $docBlock
     *
     * @return string
     */
    public function generate(DocBlock $docBlock): string
    {
        $lines = [];

        if ($docBlock->shortDescription() !== null) {
            $lines[-2][] = $this->textToComment($docBlock->shortDescription());
        }

        if ($docBlock->longDescription() !== null) {
            $lines[-1][] = $this->textToComment($docBlock->longDescription());
        }

        foreach ($this->sortTags($docBlock) as $i => $tags) {
            foreach ($tags as $tag) {
                $lines[$i][] = $this->textToComment($this->tagGenerator->generate($tag));
            }
        }

        if (count($lines) === 0) {
            return '';
        }

        $output = $this->generateLine('/**');

        foreach ($lines as $group) {
            $output .= implode('', $group);
            $output .= $this->textToComment('');
        }

        $output = rtrim($output, $this->textToComment('')) . static::END_OF_LINE;
        $output .= $this->generateLine(' */');

        return rtrim($output, static::END_OF_LINE);
    }

    /**
     * @param string $text
     * @param bool $wrap
     *
     * @return string
     */
    protected function textToComment(string $text, bool $wrap = false): string
    {
        $text = $wrap ? wordwrap($text, 80, static::END_OF_LINE) : $text;

        $comment = '';
        $lines = explode(static::END_OF_LINE, $text);

        foreach ($lines as $line) {
            $comment .= $this->generateLine(rtrim(' * ' . $line));
        }

        return $comment;
    }

    /**
     * @param DocBlock $docBlock
     *
     * @return array
     */
    protected function sortTags(DocBlock $docBlock): array
    {
        $array = [];
        $map = [
            'return' => 3,
            'throws' => 2,
            'param' => 1,
        ];

        foreach ($docBlock->tags() as $tag) {
            $key = $map[$tag->name()] ?? 0;
            $array[$key][] = $tag;
        }

        ksort($array, SORT_NATURAL | SORT_FLAG_CASE);

        if (empty($array)) {
            return [];
        }

        return $array;
    }
}
