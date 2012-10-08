<div class="message" id="candidate" style="display:none"></div>
<table class="tbl" style="width:80%">
    <thead>
        <tr>
            <td colspan="4">list of users</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>#</td>
            <td>National ID</td>
            <td>Name</td>
            <td>Control</td>
        </tr>
        <?php if($users):?>
            <?php foreach ($users as $row): ?>
                <tr id="users<?=@$row->id?>">
                    <td><?=@$row->id?></td>
                    <td><?=@$row->idn?></td>
                    <td><?=@$row->en_name?></td>
                    <td>
                        
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
                <tr>
                    <td colspan="4">Not Found</td>
                </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php if($pagination) : ?>
    <div class="message"><?=$pagination?></div>
<?php endif; ?>