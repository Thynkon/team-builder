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

    public function login()
    {
        if (isset($_SESSION)) {
            $_SESSION["user"]["id"] = $this->id;
            $_SESSION["user"]["name"] = $this->name;
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
}