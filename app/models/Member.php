<?php

require_once("app/lib/database/DB.php");
require_once("app/lib/Model.php");
require_once("app/models/Team.php");
require_once("app/models/Role.php");

class Member extends Model
{
    static public string $table = "members";
    protected string $primaryKey = "id";
    public int $id;
    public string $name;
    public string $password;
    public int $role_id;

    public static function login(int $userId = 0)
    {
        if (isset($_SESSION)) {
            $member = static::find($userId);

            $_SESSION["user"]["id"] = $member->id;
            $_SESSION["user"]["name"] = $member->name;
        }
    }

    public function teams()
    {
        $query  = sprintf("SELECT %s.* ", Team::$table);
        $query .= sprintf("FROM %s ", static::$table);
        $query .= sprintf("INNER JOIN team_member ON team_member.member_id = %s.id ", static::$table);
        $query .= sprintf("INNER JOIN %s ON %s.id = team_member.team_id ", Team::$table, Team::$table);
        $query .= sprintf("WHERE %s.id = :id ", static::$table);
        $query .= sprintf("ORDER BY %s.name;", Team::$table);

        $connector = DB::getInstance();
        return $connector->selectMany($query, ["id" => $this->id], Team::class);
    }

    public static function moderators()
    {
        $query = sprintf("SELECT `%s`.*", static::$table);
        $query .= sprintf("FROM `%s` ", static::$table);
        $query .= sprintf("INNER JOIN `%s` ON `%s`.id = %s.role_id ", Role::$table, Role::$table, static::$table);
        $query .= sprintf("WHERE `%s`.slug = 'MOD' ", Role::$table);
        $query .= sprintf("ORDER BY `%s`.name;", static::$table);

        $connector = DB::getInstance();
        return $connector->selectMany($query, [], static::class);
    }

    public function isCaptain(int $id): bool
    {
        $query  = "SELECT TRUE ";
        $query .= "FROM team_member ";
        $query .= "WHERE member_id = :member_id AND team_id = :team_id AND is_captain = true;";

        $result = null;
        $connector = DB::getInstance();

        $result = $connector->selectOne($query, ["member_id" => $this->id, "team_id" => $id]);

        // is result is empty, is means that the database returned nothing
        return $result === null ? false : true;
    }
}