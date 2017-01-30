<?php

require_once 'ParagraphParser.php';

class ChapterParser
{
    const PARAGRAPH_DIVIDER_ONE = '/(\r\n){2,}/';
    const PARAGRAPH_DIVIDER_TWO = '/\n{2,}/';

    private $encoding = '';

    public function __construct($encoding)
    {
        $this->encoding = $encoding;
    }

    public function parseText($text, $paragraphDivider)
    {
        $allWords = [];
        $text = preg_replace($paragraphDivider, "<-SEPARATOR->", $text);
        $paragraphs = explode("<-SEPARATOR->", $text);
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