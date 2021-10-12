<?php

require_once("vendor/autoload.php");
require_once(".env.php");
require_once("app/lib/View.php");
require_once("app/models/Member.php");

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
        $data["body"]["username"] = $member->name;
        $data["body"]["members"] = $members_list;

        // set title
        $data["head"]["title"] = "Team-builder";

        // get css stylesheets
        ob_start();
        require_once("resources/views/team/style.php");
        $data["head"]["css"] = ob_get_clean();

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
        $member = Member::find(USER_ID);

        $view = new View();

        $data = [];
        $data["body"]["username"] = $member->name;

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

        $view = new View();
        $data = [];
        // set title
        $data["head"]["title"] = "Team-builder";

        $team = new Team();
        $team->name = $_REQUEST["team_name"];
        // default value => Attente de validation
        $team->state_id = 2;

        $existing_team = Team::where("name", $_REQUEST["team_name"]);

        if (count($existing_team) !== 0) {
            $_SESSION["flash_message"] = "There is already a team named {$_REQUEST["team_name"]}!!!";

            // get css stylesheets
            ob_start();
            require_once("resources/views/error/style.php");
            $data["head"]["css"] = ob_get_clean();

            // get body content
            ob_start();
            require_once("resources/views/error/error.php");
            $data["body"]["content"] = ob_get_clean();

            // finally, render page
            $view->render("templates/base.php", $data);
            return;
        }

        // show error message
        if (!$team->create()) {
            $data["body"]["error_message"] = "Failed to create a new team!!!";

            // get css stylesheets
            ob_start();
            require_once("resources/views/error/error.php");
            $data["head"]["css"] = ob_get_clean();

            // get body content
            ob_start();
            require_once("resources/views/error/error.php");
            $data["body"]["content"] = ob_get_clean();

            // finally, render page
            $view->render("templates/base.php", $data);
        }

        if (!$team->setCaptain(USER_ID)) {
            $data["body"]["error_message"] = "Failed to set a new captain to the newly created team!!!";

            // get css stylesheets
            ob_start();
            require_once("resources/views/error/error.php");
            $data["head"]["css"] = ob_get_clean();

            // get body content
            ob_start();
            require_once("resources/views/error/error.php");
            $data["body"]["content"] = ob_get_clean();

            // finally, render page
            $view->render("templates/base.php", $data);
        }

        // if a new team was successfully created, redirect the user to the home page
        header('Location: index.php');
    }
}