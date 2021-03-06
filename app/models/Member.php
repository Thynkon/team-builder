<?php

require_once("app/lib/database/DB.php");
require_once("app/lib/Model.php");
require_once("app/models/Team.php");
require_once("app/models/Role.php");
require_once("app/models/Status.php");

class Member extends Model
{
    static public string $table = "members";
    protected string $primaryKey = "id";
    public int $id;
    public string $name;
    public string $password;
    public int $role_id;

    public const MEMBERSHIP_INACTIVE = 0;
    public const MEMBERSHIP_ACTIVE = 1;
    public const MEMBERSHIP_INVITATION = 2;
    public const MEMBERSHIP_REQUEST = 3;

    public const MAX_TEAM_MEMBERSHIP = 4;

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

    public function isModerator(): bool
    {
        $query  = "SELECT TRUE ";
        $query .= "FROM `members` ";
        $query .= "INNER JOIN `roles` ON `roles`.id = `members`.role_id ";
        $query .= "WHERE `roles`.slug = 'MOD' AND `members`.id = :id;";

        $result = null;
        $connector = DB::getInstance();

        $result = $connector->selectOne($query, ["id" => $this->id]);

        // is result is empty, is means that the database returned nothing
        return $result === null ? false : true;
    }

    public function belongsToTeam(int $id): bool
    {
        $query  = "SELECT true ";
        $query .= "FROM `team_member` ";
        $query .= "WHERE member_id = :member_id AND team_id = :team_id;";

        $result = null;
        $connector = DB::getInstance();

        $result = $connector->selectOne($query, ["member_id" => $this->id, "team_id" => $id]);

        // is result is empty, is means that the database returned nothing
        return $result === null ? false : true;
    }

    public function requestInvitation(int $id): bool
    {
        $query  = "INSERT INTO `team_member` ";
        $query .= "SET member_id = :member_id, team_id = :team_id, membership_type = :membership_type, is_captain = :is_captain; ";

        $connector = DB::getInstance();
        return $connector->insert($query, [
            "member_id" => $this->id,
            "team_id" => $id,
            "membership_type" => self::MEMBERSHIP_REQUEST,
            "is_captain" => 0
        ]);
    }

    public function numberOfTeams(): int
    {
        $query  = "SELECT COUNT(*) AS numberOfTeams ";
        $query .= "FROM team_member ";
        $query .= "WHERE member_id = :member_id ";
        $query .= "AND membership_type = :membership_type;";

        $result = null;
        $connector = DB::getInstance();

        $result = $connector->selectOne($query, ["member_id" => $this->id, "membership_type" => Member::MEMBERSHIP_ACTIVE]);
        if ($result !== null) {
            return $result["numberOfTeams"];
        } else {
            return 0;
        }
    }

    public function leaveTeam(int $id): bool
    {
        $query  = "DELETE FROM team_member ";
        $query .= "WHERE member_id = :member_id AND team_id = :team_id;";

        $connector = DB::getInstance();
        return $connector->execute($query, [
            "member_id" => $this->id,
            "team_id" => $id,
        ]);
    }

    public function transferCaptainRole(int $new_captain_id, int $team_id): bool
    {
        $query1  = "UPDATE team_member  ";
        $query1 .= "SET is_captain = 1 ";
        $query1 .= "WHERE team_id = :team_id AND member_id = :new_captain_id;";

        $query2  = "UPDATE team_member  ";
        $query2 .= "SET is_captain = 0 ";
        $query2 .= "WHERE team_id = :team_id AND member_id = :old_captain_id;";

        $connector = DB::getInstance();
        $connection = $connector->getConnection();

        $connection->beginTransaction();
        if (!$connector->execute($query1, [ "team_id" => $team_id, "new_captain_id" => $new_captain_id])) {
            $connection->rollback();
            return false;
        }
        if (!$connector->execute($query2, [ "team_id" => $team_id, "old_captain_id" => $this->id])) {
            $connection->rollback();
            return false;
        }
        $connection->commit();

        return true;
    }

    public function status(): Status
    {
        $query  = "SELECT `status`.* ";
        $query .= "FROM members ";
        $query .= "INNER JOIN `status` ON `status`.id = members.status_id ";
        $query .= "WHERE members.id = :id;";

        $connector = DB::getInstance();
        return $connector->selectOne($query, ["id" => $this->id], Status::class);
    }

    public function role(): Role
    {
        $query  = "SELECT `roles`.* ";
        $query .= "FROM members ";
        $query .= "INNER JOIN `roles` ON `roles`.id = members.role_id ";
        $query .= "WHERE members.id = :id;";

        $connector = DB::getInstance();
        return $connector->selectOne($query, ["id" => $this->id], Role::class);
    }

}