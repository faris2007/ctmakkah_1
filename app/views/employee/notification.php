<?php if($STEP == "view"): ?>
<div id="delete" class="tbl" style="color:white;background-color:red;display:none;text-align:center" ></div>
<div class="demo_jui">
<table class="tbl" id="list" style="width:100%">
    <thead>
        <tr>
            <td colspan="3">List of notification</td>
            <td><a href="<?=base_url()?>notification/add"><img src="<?=base_url()?>style/icon/add.png" title="<?=$this->lang->line('icon_add')?>" /></a></td>
        </tr>
        <tr>
            <td>#</td>
            <td>for type</td>
            <td>message</td>
            <td>Control</td>
        </tr>
    </thead>
    <tbody>
        <?php if(@$query): ?>
            <?php foreach(@$query as $row): ?>
                <tr id="notification<?=$row->id?>">
                    <td><?=$row->id?></td>
                    <td><?=$row->to_type?></td>
                    <td><?=substr($row->message,0,20)?>...</td>
                    <td>
                        <a href="<?=base_url()?>notification/edit/<?=$row->id?>"><img src="<?=base_url()?>style/icon/edit.png" title="<?=$this->lang->line('icon_edit')?>" /></a>
                        <a onclick="deleted('<?=base_url()?>notification/delete/<?=$row->id?>','notification<?=$row->id?>','Not have notification yet')" ><img src="<?=base_url()?>style/icon/del.png" title="<?=$this->lang->line('icon_del')?>" /></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Not have notification yet</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
</div>
<?php elseif($STEP == "add"): ?>
<form method="post">
    <table class="tbl" style="width:85%">
        <thead>
            <tr>
                <td colspan="2">Add new notification</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Type</td>
                <td>
                    <select name="type" id="type" onchange="notificationType('<?=base_url()?>',0);">
                        <option selected="selected" value="no">Select Type</option>
                        <option value="group">Group</option>
                        <option value="users">Users</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>To</td>
                <td id="dataTo">
                </td>
            </tr>
            <tr>
                <td>Message</td>
                <td><textarea name="message"></textarea></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Add" /></td>
            </tr>
            <?php if(@$ERROR): ?>
                <tr>
                    <td colspan="2" style="color:red">Error in data</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
</form>
<?php elseif($STEP == "edit"): ?>
<form method="post">
    <table class="tbl" style="width:85%">
        <thead>
            <tr>
                <td colspan="2">Edit notification</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Type</td>
                <td>
                    <select name="type" id="type" onchange="notificationType('<?=base_url()?>',<?=@$ID?>)" onloadeddata="notificationType('<?=base_url()?>',<?=@$ID?>)">
                        <option  value="no">Select Type</option>
                        <option<?=(@$TYPE=="group")?" selected=\"selected\"":""?> value="group">Group</option>
                        <option value="users">Users</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>To</td>
                <td id="dataTo"></td>
            </tr>
            <tr>
                <td>Message</td>
                <td><textarea name="message"><?=@$MESSAGE?></textarea></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="edit" /></td>
            </tr>
        </tbody>
    </table>
    
</form>
<?php elseif($STEP == "success"): ?>
<div class="message"><?=$MSG?></div>
<?php endif; ?>
