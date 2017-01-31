CREATE TABLE IF NOT EXISTS `words_en` (
  `book_id` INT UNSIGNED NOT NULL,
  `chapter_id` INT UNSIGNED NOT NULL,
  `word` VARCHAR(100) NOT NULL DEFAULT '',
  `count` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`book_id`, `chapter_id`, `word`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `words_ru` (
  `book_id` INT UNSIGNED NOT NULL,
  `chapter_id` INT UNSIGNED NOT NULL,
  `word` VARCHAR(100) NOT NULL DEFAULT '',
  `count` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`book_id`, `chapter_id`, `word`)
) ENGINE = InnoDB;