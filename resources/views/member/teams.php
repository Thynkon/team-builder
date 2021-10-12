<table>
    <?php foreach ($data["body"]["teams"] as $team): ?>
        <tr>
            <td>
                <span>
                    <a href="index.php?controller=TeamController&method=showDetails&team_id=<?= $team->id ?>"><?= $team->name ?></a>
                </span>
            </td>
            <td>
                <?= count($team->members()) ?>
            </td>
            <td>
                <?= $team->captain()->name ?>
            </td>
        </tr>
    <?php endforeach ?>
</table>