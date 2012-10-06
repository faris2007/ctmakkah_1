<div class="message"><a href="<?=base_url()?>group/show/<?=$GROUPID?>">Back To Group</a></div>
<table class="tbl">
    <thead>
        <tr>
            <td colspan="2">Result for added</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach($query as $value): ?>
            <tr>
                <td><?=$value['idn']?></td>
                <td><?=$value['message']?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
