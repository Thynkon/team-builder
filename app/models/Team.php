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

    public const MAX_MEMBERS_ALLOWED = 6;

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
        $query  = sprintf("SELECT %s.id, %s.name ", Member::$table, Member::$table);
        $query .= sprintf("FROM `team_member` ");
        $query .= sprintf("INNER JOIN %s ON %s.id = team_member.member_id ", Member::$table, Member::$table);
        $query .= sprintf("WHERE `team_member`.team_id = :id ");
        $query .= sprintf("AND team_member.is_captain = 1;");

        $connector = DB::getInstance();
        return $connector->selectOne($query, ["id" => $this->id], Member::class);
    }

    public function setCaptain(int $user_id): bool
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

    public function eligibleMembers()
    {
        $members = $this->members();
        $membersIds = array_map(function($member) {
                return $member->id;
            }, $members
        );

        $query  = sprintf("SELECT DISTINCT %s.*, COUNT(*) AS memberships ", Member::$table);
        $query .= sprintf("FROM %s ", Member::$table);
        $query .= sprintf("INNER JOIN team_member ON team_member.member_id = %s.id ", Member::$table);

        if (count($members) > 0) {
            $query .= sprintf("WHERE team_member.member_id NOT IN (");
            foreach ($membersIds as $memberId) {
                $query .= "$memberId,";
            }
            $query = substr($query, 0, -1);
            $query .= ") ";
        }

        $query .= sprintf("GROUP BY team_member.member_id ");
        $query .= sprintf("HAVING memberships < %d ", self::MAX_MEMBERS_ALLOWED);
        $query .= sprintf("ORDER BY %s.name;", Member::$table);

        $connector = DB::getInstance();
        return $connector->selectMany($query, [], Member::class);
    }

    public function addMember(int $id): bool
    {
        $query  = "INSERT INTO `team_member` ";
        $query .= "SET member_id = :member_id, team_id = :team_id, membership_type = :membership_type, is_captain = :is_captain; ";

        $connector = DB::getInstance();
        try {
            return $connector->execute($query, [
                "member_id" => $id,
                "team_id" => $this->id,
                "membership_type" => Member::MEMBERSHIP_ACTIVE,
                "is_captain" => 0
            ]);
        } catch (\PDOException $exception) {
            return false;
        }
    }

    public function isMemberEligible(int $id): bool
    {
        $member = Member::find($id);
        // if a member already belongs to a team, it is not eligible
        if ($member->belongsToTeam($this->id))  {
            return false;
        }

        $query  = "SELECT TRUE ";
        $query .= "FROM team_member ";
        $query .= "WHERE member_id = :member_id ";
        $query .= "GROUP BY member_id ";
        $query .= sprintf("HAVING COUNT(*) < %d;", self::MAX_MEMBERS_ALLOWED);

        $result = null;
        $connector = DB::getInstance();

        $result = $connector->selectOne($query, ["member_id" => $id]);

        // is result is empty, is means that the database returned nothing
        return !($result === null);
    }

    public function numberOfMembers()
    {
        $query  = "SELECT COUNT(*) AS numberOfMembers ";
        $query .= "FROM team_member ";
        $query .= "WHERE team_id = :team_id ";
        $query .= "AND membership_type = :membership_type;";

        $result = null;
        $connector = DB::getInstance();

        $result = $connector->selectOne($query, ["team_id" => $this->id, "membership_type" => Member::MEMBERSHIP_ACTIVE]);
        if ($result !== null) {
            return $result["numberOfMembers"];
        } else {
            return 0;
        }
    }

    public function state(): TeamState
    {
        $query  = sprintf("SELECT %s.* ", TeamState::$table);
        $query .= sprintf("FROM %s ", static::$table);
        $query .= sprintf("INNER JOIN %s ON %s.id = %s.state_id ", TeamState::$table, TeamState::$table, static::$table);
        $query .= sprintf("WHERE %s.id = :id;", static::$table);

        $connector = DB::getInstance();
        return $connector->selectOne($query, ["id" => $this->id], TeamState::class);
    }
}