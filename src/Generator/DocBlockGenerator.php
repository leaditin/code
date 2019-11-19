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
        $output = $this->generateLine('/**');

        if ($docBlock->shortDescription() !== null) {
            $lines[] = $this->textToComment($docBlock->shortDescription());
        }

        if ($docBlock->longDescription() !== null) {
            $lines[] = $this->textToComment($docBlock->longDescription());
        }

        foreach ($this->sortTags($docBlock) as $tag) {
            $lines[] = $this->textToComment($this->tagGenerator->generate($tag));
        }

        $output .= implode($this->textToComment(''), $lines);
        $output .= $this->generateLine(' */');

        return rtrim($output, $this->endOfLine);
    }

    /**
     * @param string $text
     * @param bool $wrap
     *
     * @return string
     */
    protected function textToComment(string $text, bool $wrap = false): string
    {
        $text = $wrap ? wordwrap($text, 80, $this->endOfLine) : $text;

        $comment = '';
        $lines = explode($this->endOfLine, $text);

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
            'property' => 1,
        ];

        foreach ($docBlock->tags() as $tag) {
            $key = $map[$tag->name()] ?? 0;
            $array[$key][] = $tag;
        }

        ksort($array, SORT_NATURAL | SORT_FLAG_CASE);

        if (empty($array)) {
            return [];
        }

        return array_merge(...$array);
    }
}
