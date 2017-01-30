<?php

require_once 'ChapterParser.php';

class BookParser
{
    const CHAPTER_DIVIDER = '<--CHAPTER-->';

    private $encoding = '';
    private $chapterDivider = '';
    private $paragraphDivider = '';

    public function __construct($encoding, $chapterDivider, $paragraphDivider)
    {
        $this->encoding = $encoding;
        $this->chapterDivider = $chapterDivider;
        $this->paragraphDivider = $paragraphDivider;
    }

    public function parseBook($text)
    {
        $bookWords = [];
        $chapters = explode($this->chapterDivider, $text);
        $chapterParser = new ChapterParser($this->encoding, $this->paragraphDivider);

        foreach ($chapters as $chapter) {
            $bookWords[] = $chapterParser->parseChapter($chapter, $this->paragraphDivider);
        }

        return $bookWords;
    }
}