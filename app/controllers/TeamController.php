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
        require_once("resources/views/member/style.php");
        $data["head"]["css"] = ob_get_clean();

        // get body content
        ob_start();
        require_once("resources/views/team/team.php");
        $data["body"]["content"] = ob_get_clean();

        // finally, render page
        $view->render("templates/base.php", $data);
    }
    public function save()
    {
        $member_list = Member::all();
        $member = Member::find(USER_ID);

        $view = new View();

        $data = [];
        $data["body"]["members"] = $member_list;
        $data["body"]["username"] = $member->name;

        // set title
        $data["head"]["title"] = "Team-builder";

        // get css stylesheets
        ob_start();
        require_once("resources/views/member/style.php");
        $data["head"]["css"] = ob_get_clean();

        // get body content
        ob_start();
        require_once("resources/views/member/member.php");
        $data["body"]["content"] = ob_get_clean();

        // finally, render page
        $view->render("templates/base.php", $data);
    }
}