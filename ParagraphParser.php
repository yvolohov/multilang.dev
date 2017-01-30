<?php

class ParagraphParser
{
    const PATTERN = '[A-Za-zА-Яа-я0-9\'\"\-]{1,}';

    private $encoding = '';

    public function __construct($encoding) {
        $this->encoding = $encoding;
    }

    public function toArray($pSentence)
    {
        mb_regex_encoding($this->encoding);

        $words = [];
        $word = '';
        $sentence = trim($pSentence);
        $sentenceLength = mb_strlen($sentence, $this->encoding);

        if ($sentenceLength > 0) {
            $firstSymbol = mb_substr($sentence, 0, 1, $this->encoding);
            $word = $firstSymbol;
        }

        $isDivider = false;

        for ($index = 1; $index < $sentenceLength; $index++) {
            $prevSymbol = mb_substr($sentence, $index - 1, 1, $this->encoding);
            $currSymbol = mb_substr($sentence, $index, 1, $this->encoding);
            $prevSymbolType = $this->getSymbolType($prevSymbol);
            $currSymbolType = $this->getSymbolType($currSymbol);

            if ($prevSymbolType !== $currSymbolType && !($isDivider)) {

                if ($prevSymbolType == 1) {
                    $word = $this->cutQuotes($word);

                    if ($word) {
                        $words[$word] = (array_key_exists($word, $words)) ? $words[$word] + 1 : 1;
                    }
                }

                $word = '';
                $isDivider = true;
            }

            if ($currSymbolType > 0) {
                $word .= $currSymbol;
                $isDivider = false;
            }
        }

        if (mb_strlen($word, $this->encoding) > 0) {

            if (mb_ereg_match(self::PATTERN, $word)) {
                $word = $this->cutQuotes($word);

                if ($word) {
                    $words[$word] = (array_key_exists($word, $words)) ? $words[$word] + 1 : 1;
                }
            }
        }

        return $words;
    }

    private function getSymbolType($pSymbol)
    {
        if ($pSymbol === "\x9" || $pSymbol === "\x20") {
            return 0;
        }
        else if (mb_ereg_match(self::PATTERN, $pSymbol)) {
            return 1;
        }
        else {
            return 2;
        }
    }

    private function cutQuotes($word) {
        $word = mb_strtolower($word, $this->encoding);
        $length = mb_strlen($word, $this->encoding);
        $firstSymbol = mb_substr($word, 0, 1, $this->encoding);
        $lastSymbol = mb_substr($word, $length - 1, 1, $this->encoding);
        $cutFromLeft = ($firstSymbol == '"' || $firstSymbol == "'") ? 1 : 0;
        $cutFromRight = ($lastSymbol == '"' || $lastSymbol == "'") ? 1 : 0;
        $cutAll = $cutFromLeft + $cutFromRight;

        if ($cutAll >= $length) {
            return false;
        }

        $word = mb_substr($word, 0, $length - $cutFromRight, $this->encoding);
        $length =  mb_strlen($word, $this->encoding);
        $word = mb_substr($word, $cutFromLeft, $length, $this->encoding);
        return $word;
    }
}