<div class="wrapper">
    <div id="team_members_list" class="pure-g">
        <?php foreach ($data["body"]["members"] as $member): ?>
            <div class="pure-u">
                <?= $member->name ?>
            </div>
        <?php endforeach ?>
    </div>
</div>