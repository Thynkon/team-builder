<p>Name: <?= $data["body"]["member"]->name?></p>
<p>Status: <?= $data["body"]["member"]->status()->value?></p>
<p>Role: <?= $data["body"]["member"]->role()->name?></p>

<?php if (count($data["body"]["member"]->teams()) > 0): ?>
    <?php foreach ($data["body"]["member"]->teams() as $memberTeam): ?>
        <p>Membre de: <?= $memberTeam->name?></p>
        <?php if ($data["body"]["member"]->isCaptain($memberTeam->id)): ?>
            <p>Capitaine de: <?= $memberTeam->name?></p>
        <?php endif ?>
    <?php endforeach ?>
<?php else: ?>
<p>Inscrit dans aucune équipe</p>
<?php endif ?>


<a href="/index.php?controller=MemberController&method=showEditProfile&member_id=<?= $data["body"]["member"]->id?>">Edit profile</a>
