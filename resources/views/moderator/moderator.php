<table>
    <?php foreach ($data["body"]["mods"] as $mod): ?>
        <tr>
            <td>
                <?= $mod->name ?>
            </td>
        </tr>
    <?php endforeach ?>
</table>