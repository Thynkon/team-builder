<form class="pure-form pure-u-1-4" action="/index.php?controller=TeamController&method=addMembers" method="post">
    <fieldset>
        <input type="hidden" name="teamId" value="<?= $data["body"]["team"]->id ?>"/>
        <?php foreach ($data["body"]["eligibleMembers"] as $eligibleMember): ?>
            <div class="pure-controls">
                <label for="eligibleMember-<?= $eligibleMember->id?>" class="pure-checkbox">
                    <input type="checkbox" id="eligibleMember-<?= $eligibleMember->id?>" name="eligibleMembers[]" value="<?= $eligibleMember->id ?>" /> <?= $eligibleMember->name ?>
                </label>
            </div>
        <?php endforeach ?>
        <button type="submit" class="pure-button pure-button-primary">Submit</button>
    </fieldset>
</form>