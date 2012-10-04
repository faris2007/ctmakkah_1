<?php if($STEP == "view"): ?>
<div id="delete" class="tbl" style="color:white;background-color:red;display:none;width:50%;text-align:center" ></div>
    <table class="tbl" id="list">
        <thead>
            <tr>
                <td colspan="4"><?=$this->lang->line('group_view')?></td>
                <?php if(@$CONTROL): ?>
                    <td><a href="<?=base_url()?>group/add"><img src="<?=base_url()?>style/icon/add.png" title="<?=$this->lang->line('icon_add')?>" /></a></td>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>#</td>
                <td><?=$this->lang->line('group_view_name')?></td>
                <td><?=$this->lang->line('group_view_location')?></td>
                <td><?=$this->lang->line('group_view_admin')?></td>
                <?php if(@$CONTROL): ?>
                    <td><?=$this->lang->line('group_view_control')?></td>
                <?php endif; ?>
            </tr>
            <?php if($query) : ?>
                <?php foreach(@$query as $row): ?>
                    <tr id="groups<?=$row->id?>">
                        <td><?=$row->id?></td>
                        <td><?=$row->name?></td>
                        <td><?=$row->location?></td>
                        <td><?=($row->is_admin=="y")? "Admin":"User"?></td>
                        <?php if(@$CONTROL): ?>
                        <td>
                            <a href="<?=base_url()?>group/edit/<?=$row->id?>"><img src="<?=base_url()?>style/icon/edit.png" title="<?=$this->lang->line('icon_edit')?>" /></a>
                            <a onclick="deleted('<?=base_url()?>group/delete/<?=$row->id?>','groups<?=$row->id?>','<?=$this->lang->line("group_view_nothing")?>')" ><img src="<?=base_url()?>style/icon/del.png" title="<?=$this->lang->line('icon_del')?>" /></a>
                        </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                    <tr>
                        <td colspan="<?=(@$CONTROL)?5:4?>"><?=$this->lang->line('group_view_nothing')?></td>
                    </tr>
            <?php endif; ?>
        </tbody>
    </table>
<?php elseif($STEP == "add"): ?>
    <form method="post">
        <table class="tbl">
            <thead>
                <tr>
                    <td colspan="2"><?=$this->lang->line('group_add')?></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$this->lang->line('group_name')?></td>
                    <td><input type="text" name="name" id="name" /></td>
                </tr>
                <tr>
                    <td><?=$this->lang->line('group_location')?></td>
                    <td><input type="text" name="location" id="location" /></td>
                </tr>
                <tr>
                    <td><?=$this->lang->line('group_admin')?></td>
                    <td>
                        <input type="radio" name="isAdmin" id="isAdmin" value="y"/><?=$this->lang->line('group_yes')?>&nbsp;&nbsp;
                        <input type="radio" name="isAdmin" id="isAdmin" value="n"/><?=$this->lang->line('group_no')?>
                    </td>
                </tr>
                <?php if(@$ERROR): ?>
                    <tr>
                        <td colspan="2"><?=$this->lang->line('group_add_error')?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td colspan="2"><input type="submit" value="<?=$this->lang->line('group_button_add')?>"/></td>
                </tr>
            </tbody>
        </table>
    </form>
<?php elseif($STEP == "edit"): ?>
    <form method="post">
        <input type="hidden" name="ID" value="<?=@$ID?>" />
        <table class="tbl">
            <thead>
                <tr>
                    <td colspan="2"><?=$this->lang->line('group_edit')?></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$this->lang->line('group_name')?></td>
                    <td><input type="text" name="name" id="name" value="<?=@$NAME?>" /></td>
                </tr>
                <tr>
                    <td><?=$this->lang->line('group_date')?></td>
                    <td><input type="text" name="location" id="location" value="<?=@$LOCATION?>" maxlength="10" /></td>
                </tr>
                <tr>
                    <td><?=$this->lang->line('group_admin')?></td>
                    <td>
                        <input type="radio" name="isAdmin" id="isAdmin"<?=(@$ISADMIN == "y")? ' checked="1"':''?> value="y"/><?=$this->lang->line('group_yes')?>&nbsp;&nbsp;
                        <input type="radio" name="isAdmin" id="isAdmin"<?=(@$ISADMIN == "n")? ' checked="1"':''?> value="n"/><?=$this->lang->line('group_no')?>
                    </td>
                </tr>
                <?php if(@$ERROR): ?>
                    <tr>
                        <td colspan="2"><?=$this->lang->line('group_add_error')?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td colspan="2"><input type="submit" value="<?=$this->lang->line('group_button_edit')?>"/></td>
                </tr>
            </tbody>
        </table>
    </form>
<?php elseif($STEP == "success"): ?>
<div>
    <?=$MSG?>
</div>
<?php endif; ?>

