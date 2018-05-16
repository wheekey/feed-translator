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

class FeedsRepository implements Repository
{
    /* @var LocalPDO */
    protected $db;

    private $tableName = "feeds";

    public function __construct()
    {
        $this->db = LocalPDO::instance();
    }

    public function findAll(): array
    {
        $stmt = $this->db->run("SELECT id, feedName, link
                                    FROM `{$this->tableName}`
                                    ");

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'kymbrik\src\model\local\Feed');

        return $stmt->fetchAll();
    }

    public function save(Model $model)
    {
        $feed = $this->findByFeedName($model->getFeedName());
        if (!$feed) {
            return $this->db->run("INSERT INTO `{$this->tableName}` (`feedName`, `link`) VALUES (?,?)",
                [
                    $model->getFeedName() ?? "",
                    $model->getLink() ?? "",
                ]);
        }
    }

    public function update(Model $model)
    {
        if (empty($model->getId())) {
            throw new \LogicException(
                'Cannot update feed that does not yet exist in the database.'
            );
        }

        return $this->db->run("UPDATE `{$this->tableName}` 
                                   SET feedName = ?, link = ? 
                                   WHERE id = ?",
            [
                $model->getFeedName(),
                $model->getLink(),
                $model->getId(),
            ]);
    }

    public function findByFeedName(string $feedName)
    {
        $stmt = $this->db->run("SELECT * FROM `{$this->tableName}` WHERE feedName = '{$feedName}'");
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'kymbrik\src\model\local\Feed');
        return $stmt->fetch();
    }

    public function findByFeedId(int $feedId)
    {
        $stmt = $this->db->run("SELECT * FROM `{$this->tableName}` WHERE id = '{$feedId}'");
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'kymbrik\src\model\local\Feed');
        return $stmt->fetch();
    }

    public function findMaxId()
    {
        return $this->db->run("SELECT MAX(id) FROM `{$this->tableName}`")->fetchColumn();
    }

    public function deleteByFeedId(int $id): bool
    {
        $stmt = $this->db->run("DELETE FROM `{$this->tableName}`
                                    WHERE id = ?
                                    ",
            [
                $id,
            ]);
        return $stmt->execute();
    }

}