<?php

require_once("vendor/autoload.php");
require_once("app/lib/View.php");
require_once("app/models/Member.php");

class MemberController
{
    public function teamsList()
    {
        $member_list = Member::orderBy("name");

        $view = new View();

        $data = [];
        $data["body"]["members"] = $member_list;

        // set title
        $data["head"]["title"] = "Team-builder";

        // get css stylesheets
        ob_start();
        require_once("resources/views/member/style.php");
        $data["head"]["css"] = ob_get_clean();

        // get body content
        ob_start();
        require_once("resources/views/templates/header.php");
        require_once("resources/views/member/member.php");
        $data["body"]["content"] = ob_get_clean();

        // finally, render page
        $view->render("templates/base.php", $data);
    }

    public function userTeamList()
    {
        $member = Member::find(USER_ID);

        $view = new View();

        $data = [];
        $data["body"]["teams"] = $member->teams();

        // set title
        $data["head"]["title"] = "Team-builder";

        // get css stylesheets
        ob_start();
        require_once("resources/views/member/style.php");
        $data["head"]["css"] = ob_get_clean();

        // get body content
        ob_start();
        require_once("resources/views/templates/header.php");
        require_once("resources/views/member/teams.php");
        $data["body"]["content"] = ob_get_clean();

        // finally, render page
        $view->render("templates/base.php", $data);
    }

    public function modsList()
    {
        $moderators_list = Member::moderators();

        $view = new View();

        $data = [];
        $data["body"]["mods"] = $moderators_list;

        // set title
        $data["head"]["title"] = "Team-builder";

        // get css stylesheets
        ob_start();
        require_once("resources/views/member/style.php");
        $data["head"]["css"] = ob_get_clean();

        // get body content
        ob_start();
        require_once("resources/views/templates/header.php");
        require_once("resources/views/moderator/moderator.php");
        $data["body"]["content"] = ob_get_clean();

        // finally, render page
        $view->render("templates/base.php", $data);
    }
}