<?php

use Thynkon\SimpleOrm\database\DB;
use Thynkon\SimpleOrm\Model;

class Team extends Model
{
    static protected string $table = "teams";
    protected string $primaryKey = "id";
    public int $id;
    public string $name;
    public int $state_id;

    public function members()
    {
        $query = <<<EOL
SELECT members.*
FROM teams
INNER JOIN team_member ON team_member.team_id = teams.id
INNER JOIN members ON members.id = team_member.member_id
WHERE teams.id = :id
ORDER BY members.name;
EOL;

        $connector = DB::getInstance();
        return $connector->selectMany($query, ["id" => $this->id], Member::class);
    }

    public function captain()
    {
        $query = <<<EOL
SELECT `members`.name
FROM `team_member`
INNER JOIN members ON members.id = team_member.member_id
WHERE `team_member`.team_id = :id
AND team_member.is_captain = 1;
EOL;

        $connector = DB::getInstance();
        return $connector->selectOne($query, ["id" => $this->id], Member::class);
    }

    public function setCaptain(int $user_id)
    {
        $query = <<< EOL
INSERT INTO `team_member`
SET member_id = :member_id, team_id = :team_id, membership_type = :membership_type, is_captain = :is_captain;
EOL;

        $connector = DB::getInstance();
        return $connector->execute($query, [
            "member_id" => $user_id,
            "team_id" => $this->id,
            "membership_type" => 1,
            "is_captain" => 1
        ]);
    }
}