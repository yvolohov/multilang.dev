<?php

/* Выполняет разбивку на абзацы */
class ParagraphParser
{
    public static function parseOne($inputFileName, $outputFileName)
    {
        $content = file_get_contents($inputFileName);
        $patternOne = '/(\r\n){2,}/';
        $content = preg_replace($patternOne, "\r\n\r\n<---->\r\n\r\n", $content);
        file_put_contents($outputFileName, $content);
    }

    public static function parseTwo($inputFileName, $outputFileName)
    {
        $content = file_get_contents($inputFileName);
        $patternOne = '/\n{2,}/';
        $content = preg_replace($patternOne, "\n\n<---->\n\n", $content);
        file_put_contents($outputFileName, $content);
    }
}