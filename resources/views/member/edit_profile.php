<?php
require_once("app/models/Role.php");
require_once("app/models/Status.php");
?>

<form class="pure-form" method="post" action="/index.php?controller=MemberController&method=updateProfile">
    <?php if ($data["body"]["current_user"]->isModerator()): ?>
        <p>
            <label>Role</label>
            <select name="member_role_id">
                <?php foreach (Role::all() as $memberRole): ?>
                    <option value="<?= $memberRole->id ?>" <?php if ($memberRole->id == $data["body"]["member"]->role_id): echo 'selected="true"'; endif; ?>><?= $memberRole->name ?></option>
                <?php endforeach ?>
            </select>
        </p>

        <p>
            <label>Status</label>
            <select name="member_status_id">
                <?php foreach (Status::all() as $memberStatus): ?>
                    <option value="<?= $memberStatus->id ?>" <?php if ($memberStatus->id == $data["body"]["member"]->status_id): echo 'selected="true"'; endif; ?>><?= $memberStatus->value ?></option>
                <?php endforeach ?>
            </select>
        </p>
    <?php else: ?>
        <p>
            <label>Name</label>
            <input type="text" name="username" value="<?= $data["body"]["member"]->name ?>"/>
        </p>
    <?php endif ?>

    <p>
        <button type="submit" class="pure-button pure-button-primary">Submit</button>
    </p>

    <input type="hidden" name="member_id" value="<?= $data["body"]["member"]->id?>"/>

</form>