<?php

require_once 'ParagraphParser.php';

class ChapterParser
{
    const PARAGRAPH_DIVIDER_ONE = '/(\r\n){2,}/';
    const PARAGRAPH_DIVIDER_TWO = '/\n{2,}/';
    const SEPARATOR = '<-SEPARATOR->';

    private $encoding = '';
    private $paragraphDivider = '';

    public function __construct($encoding, $paragraphDivider)
    {
        $this->encoding = $encoding;
        $this->paragraphDivider = $paragraphDivider;
    }

    public function parseChapter($text)
    {
        $allWords = [];
        $text = preg_replace($this->paragraphDivider, self::SEPARATOR, $text);
        $paragraphs = explode(self::SEPARATOR, $text);
        $parser = new ParagraphParser($this->encoding);

        foreach ($paragraphs as $paragraph) {
            $words = $parser->toArray($paragraph);

            foreach ($words as $word => $count) {
                $allWords[$word] = (array_key_exists($word, $allWords)) ? $allWords[$word] + $count : $count;
            }
        }

        arsort($allWords);
        return $allWords;
    }
}