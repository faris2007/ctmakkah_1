<?php if($STEP == "users"): ?>
<div class="message" id="delete" style="display:none"></div>
<div class="message">If you want Search on user who don't have personal picture <a href="<?=base_url()?>employee/users/no_pic">Click Here</a></div>
<div class="message">If you want Search on user who have personal picture <a href="<?=base_url()?>employee/users/pic">Click Here</a></div>

<div class="demo_jui">
<table class="tbl" id="list" dataajax="users" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>National ID</th>
            <th>Name</th>
            <th>Control</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!$users):?>
            <?php foreach ($users as $row): ?>
                <tr id="users<?=@$row->id?>">
                    <td><?=@$row->id?></td>
                    <td><?=@$row->idn?></td>
                    <td><?=@$row->en_name?></td>
                    <td>
                        <a href="<?=base_url()?>employee/profile/<?=$row->idn?>"><img src="<?=base_url()?>style/icon/edit.png" title="<?=$this->lang->line('icon_edit')?>" /></a>
                        <a onclick="deleted('<?=base_url()?>employee/users/0/del/<?=$row->id?>','users<?=$row->id?>','NO USER')" ><img src="<?=base_url()?>style/icon/del.png" title="<?=$this->lang->line('icon_del')?>" /></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
</div>
    <?php if($pagination):?>
        <div class="message"><?=$pagination?></div>
    <?php endif; ?>
<?php elseif ($STEP == "list"): ?>
<div class="message" id="delete" style="display:none"></div>
<?php if($users):?>
    <div class="message"><a href="<?=base_url()?>uploads/pictures.csv">Download AS CSV</a></div>
<?php endif; ?>
<div class="demo_jui">
<table class="tbl" id="list" style="width:100%">
    <thead>
        <tr>
            <td colspan="5">list of users who have picture</td>
        </tr>
        <tr>
            <th>National ID</th>
            <th>Name</th>
            <th>Position</th>
            <th>mobile</th>
            <th>Control</th>
        </tr>
    </thead>
    <tbody>
        
        <?php if($users):?>
            <?php for($i=$START;$i<($START+1000) && $i<count($users);$i++): ?>
                    <tr id="users<?=@$users[$i]->id?>">
                        <td><?=@$users[$i]->idn?></td>
                        <td><?=@$users[$i]->en_name?></td>
                        <td><?=@$users[$i]->grade?></td>
                        <td><?=@$users[$i]->mobile?></td>
                        <td>
                            <a href="<?=base_url()?>employee/profile/<?=$users[$i]->idn?>"><img src="<?=base_url()?>style/icon/edit.png" title="<?=$this->lang->line('icon_edit')?>" /></a>
                            <a onclick="deleted('<?=base_url()?>employee/users/0/del/<?=$users[$i]->id?>','users<?=$users[$i]->id?>','NO USER')" ><img src="<?=base_url()?>style/icon/del.png" title="<?=$this->lang->line('icon_del')?>" /></a>
                        </td>
                    </tr>
            <?php endfor; ?>
        <?php endif; ?>
    </tbody>
</table>
</div>
    <?php if($pagination): ?>
        <div class="message"><?=$pagination?></div>
    <?php endif; ?>
<?php elseif ($STEP == "list_no"): ?>
<div class="message" id="delete" style="display:none"></div>
<?php if($users):?>
    <div class="message"><a href="<?=base_url()?>uploads/no_pictures.csv">Download AS CSV</a></div>
<?php endif; ?>
<div class="demo_jui">
<table class="tbl" id="list" style="width:100%">
    <thead>
        <tr>
            <td colspan="5">list of users who have picture</td>
        </tr>
        <tr>
            <th>National ID</th>
            <th>Name</th>
            <th>Position</th>
            <th>mobile</th>
            <th>Control</th>
        </tr>
    </thead>
    <tbody>
        <?php if($users):?>
            <?php for($i=$START;$i<($START+1000)&& $i<count($users);$i++): ?>
                    <tr id="users<?=@$users[$i]->id?>">
                        <td><?=@$users[$i]->idn?></td>
                        <td><?=@$users[$i]->en_name?></td>
                        <td><?=@$users[$i]->grade?></td>
                        <td><?=@$users[$i]->mobile?></td>
                        <td>
                            <a href="<?=base_url()?>employee/profile/<?=$users[$i]->idn?>"><img src="<?=base_url()?>style/icon/edit.png" title="<?=$this->lang->line('icon_edit')?>" /></a>
                            <a onclick="deleted('<?=base_url()?>employee/users/0/del/<?=$users[$i]->id?>','users<?=$users[$i]->id?>','NO USER')" ><img src="<?=base_url()?>style/icon/del.png" title="<?=$this->lang->line('icon_del')?>" /></a>
                        </td>
                    </tr>
            <?php endfor; ?>
        <?php endif; ?>
    </tbody>
</table>
</div>
    <?php if($pagination): ?>
        <div class="message"><?=$pagination?></div>
    <?php endif; ?>
<?php endif; ?>

