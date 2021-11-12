<?php

require_once("vendor/autoload.php");
require_once("app/lib/View.php");
require_once("app/models/Member.php");

class MemberController
{
    public function teamsList()
    {
        $member_list = Member::orderBy("name");
        $member = Member::find(USER_ID);

        $view = new View();

        $data = [];
        $data["body"]["members"] = $member_list;
        $data["body"]["member"] = $member;

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

    public function showProfile()
    {
        $user_id = $_REQUEST["member_id"];
        $member = Member::find($user_id);

        $view = new View();

        $data = [];
        $data["body"]["member"] = $member;

        // set title
        $data["head"]["title"] = "Team-builder";

        // get css stylesheets
        ob_start();
        require_once("resources/views/member/style.php");
        $data["head"]["css"] = ob_get_clean();

        // get body content
        ob_start();
        require_once("resources/views/templates/header.php");
        require_once("resources/views/member/profile.php");
        $data["body"]["content"] = ob_get_clean();

        // finally, render page
        $view->render("templates/base.php", $data);
    }

    public function showEditProfile()
    {
        $user_id = $_REQUEST["member_id"];
        $current_user = Member::find(USER_ID);
        $member = Member::find($user_id);

        $view = new View();

        $data = [];
        $data["body"]["member"] = $member;
        $data["body"]["current_user"] = $current_user;

        // set title
        $data["head"]["title"] = "Team-builder";

        // get css stylesheets
        ob_start();
        require_once("resources/views/member/style.php");
        $data["head"]["css"] = ob_get_clean();

        // get body content
        ob_start();
        require_once("resources/views/templates/header.php");
        require_once("resources/views/member/edit_profile.php");
        $data["body"]["content"] = ob_get_clean();

        // finally, render page
        $view->render("templates/base.php", $data);
    }

    public function updateProfile()
    {
        $user_id = $_REQUEST["member_id"];
        $username = $_REQUEST["username"] ?? null;
        $role_id = $_REQUEST["member_role_id"] ?? null;
        $status_id = $_REQUEST["member_status_id"] ?? null;

        $url = "/index.php?controller=MemberController&method=showProfile&member_id=$user_id";

        $member = Member::find($user_id);
        if ($username !== null) {
            $member->name = $username;
        }

        if ($role_id !== null) {
            $member->role_id = $role_id;
        }

        if ($status_id !== null) {
            $member->status_id = $status_id;
        }

        if (!$member->save()) {
            $_SESSION["flash_message"]["type"] = FlashMessage::ERROR;
            $_SESSION["flash_message"]["value"] = "Failed to update user!";
            $_SESSION["flash_message"]["value"] .= "There already is an user named {$member->name}!";
            header("Location: $url");
            exit;
        }


        $_SESSION["flash_message"]["type"] = FlashMessage::OK;
        $_SESSION["flash_message"]["value"] = "User was successfully updated!";

        // if a new team was successfully created, redirect the user to the list of teams
        // he belongs to
        header("Location: $url");
        exit();
    }
}