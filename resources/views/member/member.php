<table>
    <?php echo "<pre>";print_r($data);echo "</pre>";foreach ($data["body"]["members"] as $member): ?>
        <tr>
            <td>
                <?= $member->name ?>
            </td>
            <td>
                <?php foreach ($member->teams() as $team): ?>
                    <span><?= $team->name ?></span>
                <?php endforeach; ?>
            </td>
        </tr>
    <?php endforeach ?>
</table>