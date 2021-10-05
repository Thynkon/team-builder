<?php

use Thynkon\SimpleOrm\database\Connector;
use Thynkon\SimpleOrm\Hydrator;

require_once("vendor/autoload.php");
require_once("app/lib/View.php");
require_once("app/models/Member.php");

class MemberController
{
    public function index()
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