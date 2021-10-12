<?php
require_once("resources/views/helpers.php");
?>

<div id="my_teams_wrapper" class="wrapper">
    <div class="flash_message"><?= flashMessage() ?></div>

    <div id="my_teams" class="pure-g">
            <?php foreach ($data["body"]["teams"] as $team): ?>
                <div class="pure-u-2-5">
                    <a href="index.php?controller=TeamController&method=showDetails&team_id=<?= $team->id ?>"><?= $team->name ?></a>
                </div>
                <div class="pure-u-1-5">
                    <?= count($team->members()) ?>
                </div>
                <div class="pure-u-1-5">
                    <?= $team->captain()->name ?>
                </div>
            <?php endforeach ?>

            <div class="pure-u-1-1">
                <a href="index.php?controller=TeamController&method=createForm">Create a new team</a>
            </div>
        </div>
</div>