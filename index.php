<?php

/* Будет три уровня парсинга:
 * - уровень книги, разбивающий книгу на главы;
 * - уровень главы, разбивающий ее на абзацы;
 * - уровень абзаца, разбивающий его на слова;
 * Парсер верхнего уровня использует парсер более низкого уровня.
 */

require_once 'ChapterParser.php';
require_once 'BookParser.php';
require_once 'DatabaseHelper.php';

/* DB */
$dbh = new DatabaseHelper('127.0.0.1', 'multilang.db', 'root', '', 'utf8');

/* English */
$bookEn = file_get_contents('./content/sign_of_four/one.en.txt');
$bookParserEn = new BookParser(
    'utf-8',
    BookParser::CHAPTER_DIVIDER,
    ChapterParser::PARAGRAPH_DIVIDER_ONE
);

$resultEn = $bookParserEn->parseBook($bookEn);
$dbh->writeWords('words_en', 1, $resultEn);

/* Russian */
$bookRu = file_get_contents('./content/sign_of_four/one.ru.txt');
$bookParserRu = new BookParser(
    'utf-8',
    BookParser::CHAPTER_DIVIDER,
    ChapterParser::PARAGRAPH_DIVIDER_TWO
);

$resultRu = $bookParserRu->parseBook($bookRu);
$dbh->writeWords('words_ru', 1, $resultRu);
