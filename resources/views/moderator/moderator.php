<div class="wrapper">
    <div id="moderators_list" class="pure-g">
        <?php foreach ($data["body"]["mods"] as $mod): ?>
            <div class="pure-u">
                <?= $mod->name ?>
            </div>
        <?php endforeach ?>
    </div>
</div>