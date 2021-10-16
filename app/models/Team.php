<?php

require_once("app/lib/database/DB.php");
require_once("app/lib/Model.php");

class Team extends Model
{
    static public string $table = "teams";
    protected string $primaryKey = "id";
    public int $id;
    public string $name;
    public int $state_id;

    public function members()
    {
        $query  = sprintf("SELECT %s.* ", Member::$table);
        $query .= sprintf("FROM %s ", static::$table);
        $query .= sprintf("INNER JOIN team_member ON team_member.team_id = %s.id ", static::$table);
        $query .= sprintf("INNER JOIN %s ON %s.id = team_member.member_id ", Member::$table, Member::$table);
        $query .= sprintf("WHERE %s.id = :id ", static::$table);
        $query .= sprintf("ORDER BY %s.name;", Member::$table);

        $connector = DB::getInstance();
        return $connector->selectMany($query, ["id" => $this->id], Member::class);
    }

    public function captain()
    {
        $query  = sprintf("SELECT `%s`.name ", Member::$table);
        $query .= sprintf("FROM `team_member` ");
        $query .= sprintf("INNER JOIN %s ON %s.id = team_member.member_id ", Member::$table, Member::$table);
        $query .= sprintf("WHERE `team_member`.team_id = :id ");
        $query .= sprintf("AND team_member.is_captain = 1;");

        $connector = DB::getInstance();
        return $connector->selectOne($query, ["id" => $this->id], Member::class);
    }

    public function setCaptain(int $user_id)
    {
        $query  = "INSERT INTO `team_member` ";
        $query .= "SET member_id = :member_id, team_id = :team_id, membership_type = :membership_type, is_captain = :is_captain; ";

        $connector = DB::getInstance();
        return $connector->execute($query, [
            "member_id" => $user_id,
            "team_id" => $this->id,
            "membership_type" => 1,
            "is_captain" => 1
        ]);
    }
}