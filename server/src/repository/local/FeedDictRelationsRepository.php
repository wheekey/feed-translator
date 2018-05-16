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

class FeedDictRelationsRepository implements Repository
{
    /* @var LocalPDO */
    protected $db;

    private $tableName = "feed_dictionary";

    public function __construct()
    {
        $this->db = LocalPDO::instance();
    }

    public function findAll(): array
    {
        $stmt = $this->db->run("SELECT feedId, dictionaryId
                                    FROM `{$this->tableName}`
                                    ");

        return $stmt->fetchAll();
    }

    public function save(int $feedId, int $dictionaryId)
    {
        $feed = $this->findRelation($feedId, $dictionaryId);
        if (!$feed) {
            return $this->db->run("INSERT INTO `{$this->tableName}` (`feedId`, `dictionaryId`) VALUES (?,?)",
                [
                    $feedId,
                    $dictionaryId,
                ]);
        }
    }

    public function deleteRelationsByFeedId(int $feedId)
    {
        $stmt = $this->db->run("DELETE FROM `{$this->tableName}`
                                    WHERE feedId = ?
                                    ",
            [
                $feedId,
            ]);
        return $stmt->execute();
    }

    public function delete(int $feedId, int $dictionaryId): bool
    {
        $stmt = $this->db->run("DELETE FROM `{$this->tableName}`
                                    WHERE feedId = ? AND dictionaryId = ?
                                    ",
            [
                $feedId,
                $dictionaryId,
            ]);
        return $stmt->execute();
    }

    public function findRelation(int $feedId, int $dictionaryId)
    {
        $stmt = $this->db->run("SELECT * FROM `{$this->tableName}` WHERE feedId = '{$feedId}' AND dictionaryId = '{$dictionaryId}'");

        return $stmt->fetch();
    }

}