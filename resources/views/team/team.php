<table>
    <?php foreach ($data["body"]["members"] as $member): ?>
        <tr>
            <td>
                <?= $member->name ?>
            </td>
        </tr>
    <?php endforeach ?>
</table>