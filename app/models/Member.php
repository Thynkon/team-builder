<?php

use Thynkon\SimpleOrm\database\Connector;
use Thynkon\SimpleOrm\Model;

require_once("app/models/Team.php");

class Member extends Model
{
    static protected string $table = "members";
    protected string $primaryKey = "id";
    public int $id;
    public string $name;
    public string $password;
    public int $role_id;

    public function login()
    {
        if (isset($_SESSION)) {
            $_SESSION["user"]["id"] = $this->id;
            $_SESSION["user"]["name"] = $this->name;
        }

        echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";
    }

    public function teams()
    {
        $connector = \Thynkon\SimpleOrm\database\Connector::getInstance();
        $query = <<<EOL
SELECT teams.`name`
FROM members
INNER JOIN team_member ON team_member.member_id = members.id
INNER JOIN teams ON teams.id = team_member.team_id
WHERE members.id = :id;
EOL;

        $connector = Connector::getInstance();
        $connection = $connector->getConnection();
        $statement = $connection->prepare($query);

        if ($statement->execute(["id" => $this->id])) {
            $result = $statement->fetchAll(\PDO::FETCH_CLASS, Team::class);
        }

        return $result;
    }
}