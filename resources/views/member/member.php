<div class="pure-g header" xmlns:a="http://www.w3.org/1999/html">
    <h1 class="pure-u">
        <a href="/index.php">Team builder</a>
    </h1>
    <div id="login_username" class="pure-u">
        Authentifié en tant que: <?= $data["body"]["username"]?>
    </div>
</div>


<table>
    <?php foreach ($data["body"]["members"] as $member): ?>
        <tr>
            <td>
                <?= $member->name ?>
            </td>
            <td>
                <?php foreach ($member->teams() as $team): ?>
                    <span>
                        <a href="index.php?controller=TeamController&method=showDetails&team_id=<?= $team->id ?>"><?= $team->name ?></a>
                    </span>
                <?php endforeach; ?>
            </td>
        </tr>
    <?php endforeach ?>
</table>