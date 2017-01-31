<?php

class DatabaseHelper
{
    private $pdo;

    public function __construct($host, $db, $user, $password, $charset)
    {
        try {
            $dsn = "mysql:host={$host};dbname={$db};charset={$charset}";
            $this->pdo = new \PDO($dsn, $user, $password);
        }
        catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function writeWords($tableName, $bookId, $chapters)
    {
        $deleteRequest = "DELETE FROM {$tableName};";
        $insertRequest = "INSERT INTO {$tableName} (book_id, chapter_id, word, words_count)" .
            " VALUES (:book_id, :chapter_id, :word, :words_count);";

        $stmt = $this->pdo->prepare($insertRequest);
        $this->pdo->query($deleteRequest);

        echo "START WRITING TO {$tableName}" . PHP_EOL;

        foreach ($chapters as $chapterKey => $chapter) {
            $chapterId = $chapterKey + 1;
            echo "WRITE CHAPTER #{$chapterId}" . PHP_EOL;

            foreach ($chapter as $word => $count) {
                $stmt->execute([
                    'book_id' => $bookId,
                    'chapter_id' => $chapterId,
                    'word' => $word,
                    'words_count' => $count
                ]);
            }
        }

        echo "END WRITING TO {$tableName}" . PHP_EOL;
    }
}