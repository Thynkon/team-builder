<div class="wrapper">
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
</div>