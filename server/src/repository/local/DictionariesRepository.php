<?php
/**
 * Created by PhpStorm.
 * User: ermakov
 * Date: 13.03.18
 * Time: 16:37
 */

namespace kymbrik\src\repository\local;

use kymbrik\src\pdo\LocalPDO;

use kymbrik\src\model\Model;
use kymbrik\src\repository\Repository;
use PDO;

class DictionariesRepository implements Repository
{
    /* @var LocalPDO */
    protected $db;

    private $tableName = "dictionaries";

    public function __construct()
    {
        $this->db = LocalPDO::instance();
    }

    public function findAll(): array
    {
        $stmt = $this->db->run("SELECT id, `language`, fileName
                                    FROM `{$this->tableName}`
                                    ");

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'kymbrik\src\model\local\Dictionary');

        return $stmt->fetchAll();
    }

    public function findAllByFeedId(int $feedId): array
    {
        $stmt = $this->db->run("SELECT dict.id, dict.language, dict.fileName
                                    FROM `{$this->tableName}` AS dict
                                    WHERE dict.id IN (SELECT dictionaryId AS id FROM `feed_dictionary` WHERE feedId = ?)
                                    ", [$feedId]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'kymbrik\src\model\local\Dictionary');

        return $stmt->fetchAll();
    }

    public function findAllByLanguage(string $language): array
    {
        $stmt = $this->db->run("SELECT dict.id, dict.language, dict.fileName 
                                    FROM `{$this->tableName}` AS dict 
                                    WHERE dict.language = ?
                                    ", [$language]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'kymbrik\src\model\local\Dictionary');

        return $stmt->fetchAll();
    }

    public function save(Model $model)
    {
        $feed = $this->findByFileName($model->getFileName());
        if (!$feed) {
            return $this->db->run("INSERT INTO `{$this->tableName}` (`language`, `fileName`) VALUES (?,?)",
                [
                    $model->getLanguage() ?? "",
                    $model->getFileName() ?? "",
                ]);
        }
    }

    public function findByFileName(string $fileName)
    {
        $stmt = $this->db->run("SELECT * FROM `{$this->tableName}` WHERE fileName = '{$fileName}'");

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'kymbrik\src\model\local\Dictionary');

        return $stmt->fetch();
    }

    public function findMaxId()
    {
        return $this->db->run("SELECT MAX(id) FROM `{$this->tableName}`")->fetchColumn();
    }

    public function findAllWithDistinctLanguages()
    {
        $stmt = $this->db->run("SELECT MIN(dict.id) AS id, dict.language, MIN(dict.fileName) AS fileName 
                                    FROM `{$this->tableName}` AS dict 
                                    GROUP BY dict.language
                                    ");
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'kymbrik\src\model\local\Dictionary');
        return $stmt->fetchAll();
    }

}