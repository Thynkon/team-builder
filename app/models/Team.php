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
}