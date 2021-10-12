<?php

function flashMessage()
{
    if (isset($_SESSION["flash_message"])) {
        $message = $_SESSION["flash_message"];
        unset($_SESSION["flash_message"]);
    }

    return $message;
}