<?php

require_once(sprintf("%s/config/config.php", dirname($_SERVER['DOCUMENT_ROOT'])));
require_once(".env.php");
require_once("vendor/autoload.php");

require_once("app/controllers/HomePageController.php");
require_once("app/controllers/MemberController.php");
require_once("app/controllers/TeamController.php");

session_start();

function main()
{
    $controller = "HomePageController";
    $method = "index";

    if (isset($_GET["controller"])) {
        $controller = $_GET["controller"];
    }

    if (isset($_GET["method"])) {
        $method = $_GET["method"];
    }

    // store user information in $_SESSION
    Member::login(USER_ID);

    $c = new $controller();
    $c->$method();
}

main();