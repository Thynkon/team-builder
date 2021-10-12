<?php

require_once("vendor/autoload.php");
require_once("app/lib/View.php");
require_once("app/models/Member.php");

class HomePageController
{
    public function index()
    {
        $member = Member::find(USER_ID);
        $member->login();

        $view = new View();

        $data = [];
        $data["body"]["username"] = $member->name;

        // set title
        $data["head"]["title"] = "Team-builder";

        // get css stylesheets
        ob_start();
        require_once("resources/views/home/style.php");
        $data["head"]["css"] = ob_get_clean();

        // get body content
        ob_start();
        require_once("resources/views/templates/header.php");
        require_once("resources/views/home/home.php");
        $data["body"]["content"] = ob_get_clean();

        // finally, render page
        $view->render("templates/base.php", $data);
    }
}