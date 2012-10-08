<div class="message" id="delete" style="display:none"></div>
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
                        <a href="<?=base_url()?>employee/profile/<?=$row->id?>"><img src="<?=base_url()?>style/icon/edit.png" title="<?=$this->lang->line('icon_edit')?>" /></a>
                        <a onclick="deleted('<?=base_url()?>employee/users/0/del/<?=$row->id?>','users<?=$row->id?>','NO USER')" ><img src="<?=base_url()?>style/icon/del.png" title="<?=$this->lang->line('icon_del')?>" /></a>
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
    <div class="message"><?=$pagination?></div>
