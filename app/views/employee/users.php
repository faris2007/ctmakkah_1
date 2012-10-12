<?php if($STEP == "users"): ?>
<div class="message" id="delete" style="display:none"></div>
<div class="message">If you want Search on user who don't have personal picture <a href="<?=base_url()?>employee/users/no_pic">Click Here</a></div>
<table class="tbl">
    <thead>
        <tr>
            <td colspan="2">Search for any user By ID National</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>ID National :</td>
            <td><input type="text" name="IDN" id="IDN" placeholder="ID .." /></td>
        </tr>
        <tr>
            <td colspan="2"><button onclick="window.location = '<?=base_url()?>employee/profile/'+$('#IDN').val()+'/users';">Search</button></td>
        </tr>
    </tbody>
</table>

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
                        <a href="<?=base_url()?>employee/profile/<?=$row->idn?>"><img src="<?=base_url()?>style/icon/edit.png" title="<?=$this->lang->line('icon_edit')?>" /></a>
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
<?php elseif ($STEP == "list"): ?>
<div class="message" id="delete" style="display:none"></div>
<table class="tbl" style="width:80%">
    <thead>
        <tr>
            <td colspan="4">list of users who don't have picture</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>National ID</td>
            <td>Name</td>
            <td>mobile</td>
            <td>Control</td>
        </tr>
        <?php if($users):$folder = 'store/personal_img/';?>
            <?php foreach ($users as $row): ?>
                <?php if(!file_exists($folder.$row->idn.".jpg") && !file_exists($folder.$row->idn.".jpeg") && !file_exists($folder.$row->idn.".png")
                   && !file_exists($folder.$row->idn." .png") && !file_exists($folder.$row->idn." .jpg" ) && !file_exists($folder.$row->idn.".PNG") && !file_exists($folder.$row->idn.".JPG")): ?>
                    <tr id="users<?=@$row->id?>">
                        <td><?=@$row->idn?></td>
                        <td><?=@$row->en_name?></td>
                        <td>0<?=@$row->mobile?></td>
                        <td>
                            <a href="<?=base_url()?>employee/profile/<?=$row->idn?>"><img src="<?=base_url()?>style/icon/edit.png" title="<?=$this->lang->line('icon_edit')?>" /></a>
                            <a onclick="deleted('<?=base_url()?>employee/users/0/del/<?=$row->id?>','users<?=$row->id?>','NO USER')" ><img src="<?=base_url()?>style/icon/del.png" title="<?=$this->lang->line('icon_del')?>" /></a>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
                <tr>
                    <td colspan="4">Not Found</td>
                </tr>
        <?php endif; ?>
    </tbody>
</table>
    <div class="message"><?=$pagination?></div>    
<?php endif; ?>

