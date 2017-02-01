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

            foreach ($words as $word => $wordParams) {

                if (array_key_exists($word, $allWords)) {
                    $allWords[$word]['words_count'] = $allWords[$word]['words_count'] + $wordParams['words_count'];
                    $allWords[$word]['uppercase'] = ($wordParams['uppercase'] > 0) ? 1 : $allWords[$word]['uppercase'];
                    $allWords[$word]['lowercase'] = ($wordParams['lowercase'] > 0) ? 1 : $allWords[$word]['lowercase'];
                }
                else {
                    $allWords[$word] = [
                        'words_count' => $wordParams['words_count'],
                        'uppercase' => $wordParams['uppercase'],
                        'lowercase' => $wordParams['lowercase']
                    ];
                }

                //$allWords[$word] = (array_key_exists($word, $allWords)) ? $allWords[$word] + $count : $count;
            }
        }

        arsort($allWords);
        return $allWords;
    }
}