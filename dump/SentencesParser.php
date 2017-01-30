<?php

class SentencesParser
{
    public static function parseGutenberg($inputFileName, $outputFileName)
    {
        $rawParagraphs = self::getParagraphs($inputFileName);
        $paragraphs = [];

        foreach ($rawParagraphs as $rawParagraph) {
            $paragraphs[] = self::getSentences($rawParagraph);
        }

        file_put_contents($outputFileName, print_r($paragraphs, True));
    }

    private static function getParagraphs($fileName) {
        $content = file_get_contents($fileName);
        $patternOne = '/(\r\n){2,}/';

        $content = preg_replace($patternOne, '<paragraph>', $content);
        $rawParagraphs = explode('<paragraph>', $content);

        $patternTwo = '/\r\n/';
        $paragraphs = [];

        foreach ($rawParagraphs as $rawParagraph) {
            $paragraph = trim($rawParagraph);

            if (strlen($paragraph) == 0) {
                continue;
            }

            $paragraph = preg_replace($patternTwo, ' ', $paragraph);
            $paragraphs[] = $paragraph;
        }

        return $paragraphs;
    }

    private static function getSentences($paragraph) {
        $pattern = '/[\.\?\!][\"\']?[ ]+[\"\']?[A-Z]/';
        $matches = [];
        preg_match_all($pattern, $paragraph, $matches, PREG_OFFSET_CAPTURE);
        $dividePoints = self::getDividePoints($matches);
        $paragraphLength = strlen($paragraph);

        $sentences = [];
        $sentence = '';

        for ($index = 0; $index <= $paragraphLength; $index++) {

            if (in_array($index, $dividePoints) || $index == $paragraphLength) {
                $sentences[] = trim($sentence);
                $sentence = '';
                continue;
            }

            $currentSymbol = substr($paragraph, $index, 1);
            $sentence .= $currentSymbol;
        }

        return $sentences;
    }

    private static function getDividePoints($matches) {
        $dividePoints = [];

        foreach ($matches[0] as $match) {
            $spacePos = strpos($match[0], ' ');
            $dividePoints[] = $match[1] + $spacePos;
        }

        return $dividePoints;
    }
}