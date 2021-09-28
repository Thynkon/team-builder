<?php

namespace CPNV;

require_once('.env.php');

class DB
{

    static private function getDbConnection()
    {
        return new \PDO(DSN, USERNAME, PASSWORD);
    }

    static public function selectMany($query, $args)
    {
        $db_connection = self::getDbConnection();
        $statement = $db_connection->prepare($query);

        if ($statement->execute($args)) {
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        }

        // close db connection
        $statement = null;
        $db_connection = null;

        return false;
    }

    static public function selectOne($query, $args)
    {
        $db_connection = self::getDbConnection();
        $statement = $db_connection->prepare($query);

        if ($statement->execute($args)) {
            return $statement->fetch(\PDO::FETCH_ASSOC);
        }

        // close db connection
        $statement = null;
        $db_connection = null;

        return false;
    }

    static public function insert($query, $args)
    {
        $db_connection = self::getDbConnection();
        $statement = $db_connection->prepare($query);

        try {
            $statement->execute($args);
            return $db_connection->lastInsertId();
        } catch (\PDOException $exception) {
            return false;
        }
    }

    static public function execute($query, $args)
    {
        $db_connection = self::getDbConnection();
        $statement = $db_connection->prepare($query);

        try {
            $statement->execute($args);
            return $statement->rowCount();
        } catch (\PDOException $exception) {
            return false;
        }
    }
}