<?php

/* Будет три уровня парсинга:
 * - уровень книги, разбивающий книгу на главы;
 * - уровень главы, разбивающий ее на абзацы;
 * - уровень абзаца, разбивающий его на слова;
 * Парсер верхнего уровня использует парсер более низкого уровня.
 */

require_once 'ChapterParser.php';
require_once 'BookParser.php';

$book = file_get_contents('./content/sign_of_four/one.en.txt');

$bookParser = new BookParser(
    'utf-8',
    BookParser::CHAPTER_DIVIDER,
    ChapterParser::PARAGRAPH_DIVIDER_ONE
);

$result = $bookParser->parseBook($book);
file_put_contents('./content/sign_of_four/two.en.txt', print_r($result, True));