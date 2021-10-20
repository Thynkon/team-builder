<?php

require_once("vendor/autoload.php");
require_once(".env.php");
require_once("app/lib/View.php");
require_once("app/models/Member.php");
require_once("app/lib/FlashMessage.php");

class TeamController
{
    public function showDetails()
    {
        if (!isset($_REQUEST["team_id"])) {
            // temporary check
            // should display an error message and
            // return a proper HTTP error code
            exit;
        }

        $team = Team::find($_REQUEST["team_id"]);
        $members_list = $team->members();
        $member = Member::find(USER_ID);

        $view = new View();

        $data = [];
        $data["body"]["team"] = $team;
        $data["body"]["members"] = $members_list;

        // set title
        $data["head"]["title"] = "Team-builder";

        // get css stylesheets
        ob_start();
        require_once("resources/views/team/style.php");
        $data["head"]["css"] = ob_get_clean();

        if ($member->isCaptain($team->id)) {
            ob_start();
            $data["body"]["eligibleMembers"] = $team->eligibleMembers();
            $data["body"]["team"] = $team;
            require_once("resources/views/team/add_members.php");
            $data["body"]["addTeamForm"] = ob_get_clean();
        }

        // get body content
        ob_start();
        require_once("resources/views/templates/header.php");
        require_once("resources/views/team/list.php");
        $data["body"]["content"] = ob_get_clean();

        // finally, render page
        $view->render("templates/base.php", $data);
    }

    public function createForm()
    {
        $member_list = Member::all();

        $view = new View();
        $data = [];

        // set title
        $data["head"]["title"] = "Team-builder";

        // get css stylesheets
        ob_start();
        require_once("resources/views/team/style.php");
        $data["head"]["css"] = ob_get_clean();

        // get body content
        ob_start();
        require_once("resources/views/templates/header.php");
        require_once("resources/views/team/create.php");
        $data["body"]["content"] = ob_get_clean();

        // finally, render page
        $view->render("templates/base.php", $data);
    }

    public function create()
    {
        if (!isset($_REQUEST["team_name"])) {
            // temporary check
            // should display an error message and
            // return a proper HTTP error code
            exit;
        }

        $url = "index.php?controller=MemberController&method=userTeamList";

        $view = new View();
        $data = [];
        // set title
        $data["head"]["title"] = "Team-builder";

        $team = new Team();
        $team->name = $_REQUEST["team_name"];
        // default value => Attente de validation
        $team->state_id = 2;

        if (!$team->create()) {
            $_SESSION["flash_message"]["type"] = FlashMessage::ERROR;
            $_SESSION["flash_message"]["value"] = "Failed to create a new team!!!";
            $_SESSION["flash_message"]["value"] .= " There is already a team named {$_REQUEST["team_name"]}!!!";
            header("Location: $url");
        }

        if (!$team->setCaptain(USER_ID)) {
            $_SESSION["flash_message"]["type"] = FlashMessage::ERROR;
            $_SESSION["flash_message"]["value"] = "Failed to set a new captain to the newly created team!!!";

            header("Location: $url");
        }

        $_SESSION["flash_message"]["type"] = FlashMessage::OK;
        $_SESSION["flash_message"]["value"] = "Team {$team->name} was successfully created!";

        // if a new team was successfully created, redirect the user to the list of teams
        // he belongs to
        header("Location: $url");
    }

    public function addMembers()
    {
        $url = "/index.php";
        if (!isset($_REQUEST["eligibleMembers"])) {
            $_SESSION["flash_message"]["type"] = FlashMessage::ERROR;
            $_SESSION["flash_message"]["value"] = "You have to select at least one member!";

            header("Location: $url");
        }

        if (!isset($_REQUEST["teamId"])) {
            $_SESSION["flash_message"]["type"] = FlashMessage::ERROR;
            $_SESSION["flash_message"]["value"] = "Missing team id!";

            header("Location: $url");
        }

        $team = Team::find($_REQUEST["teamId"]);
        foreach ($_REQUEST["eligibleMembers"] as $memberId) {
            if (!$team->isMemberEligible($team->id)) {
                $_SESSION["flash_message"]["type"] = FlashMessage::ERROR;
                $_SESSION["flash_message"]["value"] = "Member with id => $memberId is not eligible !";
                $_SESSION["flash_message"]["value"] .= "You may want to check how many teams he belongs to!";

                header("Location: $url");
            }

            if (!$team->addMember($memberId)) {
                if (!isset($_REQUEST["teamId"])) {
                    $_SESSION["flash_message"]["type"] = FlashMessage::ERROR;
                    $_SESSION["flash_message"]["value"] = "Member with id => $memberId was not added to the team!";

                    header("Location: $url");
                }
            }
        }

        $_SESSION["flash_message"]["type"] = FlashMessage::OK;
        $_SESSION["flash_message"]["value"] = "Members were successfully added to {$team->name}";
        $url = "/index.php?controller=TeamController&method=showDetails&team_id={$_REQUEST["teamId"]}";

        // if a new team was successfully created, redirect the user to the list of teams
        // he belongs to
        header("Location: $url");
    }
}