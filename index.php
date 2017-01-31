<?php

/* Будет три уровня парсинга:
 * - уровень книги, разбивающий книгу на главы;
 * - уровень главы, разбивающий ее на абзацы;
 * - уровень абзаца, разбивающий его на слова;
 * Парсер верхнего уровня использует парсер более низкого уровня.
 */

require_once 'ChapterParser.php';
require_once 'BookParser.php';

/* English */
$bookEn = file_get_contents('./content/sign_of_four/one.en.txt');
$bookParserEn = new BookParser(
    'utf-8',
    BookParser::CHAPTER_DIVIDER,
    ChapterParser::PARAGRAPH_DIVIDER_ONE
);

$resultEn = $bookParserEn->parseBook($bookEn);
file_put_contents('./content/sign_of_four/two.en.txt', print_r($resultEn, True));

/* Russian */
$bookRu = file_get_contents('./content/sign_of_four/one.ru.txt');
$bookParserRu = new BookParser(
    'utf-8',
    BookParser::CHAPTER_DIVIDER,
    ChapterParser::PARAGRAPH_DIVIDER_TWO
);

$resultRu = $bookParserRu->parseBook($bookRu);
file_put_contents('./content/sign_of_four/two.ru.txt', print_r($resultRu, True));