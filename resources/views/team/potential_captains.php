<form class="pure-form pure-u-1-4" action="/index.php?controller=TeamController&method=transferCaptainRole" method="post">
    <fieldset>
        <input type="hidden" name="team_id" value="<?= $data["body"]["team"]->id ?>"/>
        <div class="pure-controls">
            <select name="potential_captain">
                <?php foreach ($data["body"]["members"] as $teamMember): ?>
                    <?php if (!$teamMember->isCaptain($data["body"]["team"]->id)): ?>
                        <option value="<?= $teamMember->id ?>"><?= $teamMember->name ?></option>
                    <?php endif ?>
                <?php endforeach ?>
            </select>
        </div>
        <button type="submit" class="pure-button pure-button-primary">Submit</button>
    </fieldset>
</form>
