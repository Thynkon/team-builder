<?php

function flashMessage()
{
    $message = "";

    if (isset($_SESSION["flash_message"])) {
        $message = $_SESSION["flash_message"];
        unset($_SESSION["flash_message"]);
    }

    return $message;
}