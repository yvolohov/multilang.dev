<?php

/* Будет три уровня парсинга:
 * - уровень книги, разбивающий книгу на главы;
 * - уровень главы, разбивающий ее на абзацы;
 * - уровень абзаца, разбивающий его на слова;
 * Парсер верхнего уровня использует парсер более низкого уровня.
 */

require_once 'ChapterParser.php';

$text = file_get_contents('./content/sign_of_four/source.en.txt');

$chapterParser = new ChapterParser('utf-8');
$allWords = $chapterParser->parseText($text, ChapterParser::PARAGRAPH_DIVIDER_ONE);

file_put_contents('./content/sign_of_four/one.en.txt', print_r($allWords, True));