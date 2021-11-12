<div class="wrapper">
    <table>
        <?php foreach ($data["body"]["members"] as $member): ?>
            <tr>
                <td>
                    <?php if ($data["body"]["member"]->isModerator()): ?>
                        <a href="/index.php?controller=MemberController&method=showProfile&member_id=<?= $member->id?>"><?= $member->name ?></a>
                    <?php else: ?>
                        <?= $member->name ?>
                    <?php endif ?>
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