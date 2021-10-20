<div class="wrapper has-text-centered">
    <div id="team_members_list" class="pure-u-1-4">
        <?php foreach ($data["body"]["members"] as $teamMember): ?>
            <div>
                <?= $teamMember->name ?>
            </div>
        <?php endforeach ?>
    </div>

    <?= $data["body"]["addTeamForm"] ?? "" ?>
</div>