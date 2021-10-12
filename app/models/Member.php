<?php

require_once("app/lib/database/DB.php");
require_once("app/lib/Model.php");
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
    }

    public function teams()
    {
        $query = <<<EOL
SELECT teams.*
FROM members
INNER JOIN team_member ON team_member.member_id = members.id
INNER JOIN teams ON teams.id = team_member.team_id
WHERE members.id = :id
ORDER BY teams.name;
EOL;

        $connector = DB::getInstance();
        return $connector->selectMany($query, ["id" => $this->id], Team::class);
    }

    public static function moderators()
    {
        $query = <<<EOL
SELECT `members`.*
FROM `members`
INNER JOIN `roles` ON `roles`.id = members.role_id
WHERE `roles`.slug = "MOD"
ORDER BY `members`.name;
EOL;

        $connector = DB::getInstance();
        return $connector->selectMany($query, [], static::class);
    }
}