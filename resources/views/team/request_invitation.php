<form class="pure-form pure-u-1-4" action="/index.php?controller=TeamController&method=requestInvitation" method="post">
    <fieldset>
        <input type="hidden" name="teamId" value="<?= $data["body"]["team"]->id ?>"/>
        <input type="hidden" name="memberId" value="<?= $data["body"]["user"]->id ?>"/>
        <div class="pure-controls">
            <label for="requestInvitation" class="pure-checkbox">
                <input type="checkbox" id="requestInvitation" name="requestInvitation"/> Request invitation
            </label>
        </div>
        <button type="submit" class="pure-button pure-button-primary">Submit</button>
    </fieldset>
</form>