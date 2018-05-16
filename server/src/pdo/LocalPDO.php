<?php
/**
 * Created by PhpStorm.
 * User: ermakov
 * Date: 20.02.18
 * Time: 16:38
 */

namespace kymbrik\src\pdo;

use PDO;

class LocalPDO
{
    protected static $instance;
    protected $pdo;

    protected function __construct()
    {
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false,
        );
        $dsn = 'mysql:host=' . getenv("MYSQL_LOCAL_HOSTNAME") . ';dbname=' . getenv("MYSQL_LOCAL_DBNAME") . ';charset=' . getenv("MYSQL_LOCAL_CHARSET");
        $this->pdo = new PDO($dsn, getenv("MYSQL_LOCAL_USERNAME"), getenv("MYSQL_LOCAL_PASSWORD"), $opt);
    }

    // a classical static method to make it universally available
    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // a proxy to native PDO methods
    public function __call($method, $args)
    {
        return call_user_func_array(array($this->pdo, $method), $args);
    }

    // a helper function to run prepared statements smoothly
    public function run($sql, $args = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }
}