<?php
require_once("app/lib/FlashMessage.php");

$message = FlashMessage::get();
?>

<div class="pure-g header" xmlns:a="http://www.w3.org/1999/html">
    <h1 class="pure-u">
        <a id="main_title" href="/index.php">Team builder</a>
    </h1>

    <div id="login_username_parent" class="pure-g">
        <div id="login_username" class="pure-u">
            Authentifié en tant que: <?= $_SESSION["user"]["name"]?>
        </div>
    </div>

    <div class="pure-u flash_message <?= is_array($message) ? ($message["type"] === FlashMessage::OK ? "ok" : "error") : "" ?>"><?= is_array($message) ? $message["value"] : ""?></div>
</div>
