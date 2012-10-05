<?php if($STEP == "view"): ?>
<div id="delete" class="tbl" style="color:white;background-color:red;display:none;width:50%;text-align:center" ></div>
    <table class="tbl" id="list" style="width:80%">
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
                            <a href="<?=base_url()?>group/show/<?=$row->id?>"><img src="<?=base_url()?>style/icon/show.png" title="<?=$this->lang->line('icon_show')?>" /></a>
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
<?php elseif($STEP == "show"): ?>
<div class="message" id="delete" style="display:none"></div>
<table class="tbl" style="width:80%">
    <thead>
        <tr>
            <td colspan="2"><?=$this->lang->line('group_edit')?></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?=$this->lang->line('group_name')?></td>
            <td><input type="text" name="name" id="name" value="<?=@$NAME?>" disabled="1" /></td>
        </tr>
        <tr>
            <td><?=$this->lang->line('group_location')?></td>
            <td><input type="text" name="location" id="location" value="<?=@$LOCATION?>" disabled="1" /></td>
        </tr>
        <tr>
            <td><?=$this->lang->line('group_admin')?></td>
            <td>
                <input type="text" name="admin" id="admin" value="<?=@($ISADMIN=="y")?"Admin":"User"?>" disabled="1" />
            </td>
        </tr>
    </tbody>
</table>
<br />
<div class="message">
    permissions for this Group if you want add new permission <a href="<?=base_url()?>group/addpermissontogroup/<?=@$ID?>">click here</a>
</div>
        <table class="tbl" style="width:80%">
            <thead>
                <tr>
                    <td colspan="2">add new permission to this group</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Services Name</td>
                    <td>Permission</td>
                    <td>Remove</td>
                </tr>
                <?php if($services): ?>
                    <?php foreach ($services as  $service): ?>
                        <tr id="permissions<?=@$service->id?>"> 
                            <td><?=$service->service_name?></td>
                            <td><?=$service->function_name?></td>
                            <td><button onclick="deleted('<?=base_url()?>group/delete/<?=@$service->id?>/permissions','permissions<?=@$service->id?>')">delete</button></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                        <tr>
                            <td colspan="3">Not Found</td>
                        </tr>
                <?php endif; ?>
            </tbody>
        </table>
<br />
<div class="message">
    users in this Group if you want add new user <a href="<?=base_url()?>group/adduserstogroup/<?=@$ID?>">click here</a>
</div>
        <table class="tbl" style="width:80%">
            <thead>
                <tr>
                    <td colspan="2">add new user to this group</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#</td>
                    <td>National ID</td>
                    <td>Name</td>
                    <td>Remove</td>
                </tr>
                <?php if($users):?>
                    <?php foreach ($users as $row): ?>
                        <tr id="users<?=@$row->id?>">
                            <td><?=@$row->id?></td>
                            <td><?=@$row->idn?></td>
                            <td><?=@$row->en_name?></td>
                            <td><button onclick="deleted('<?=base_url()?>group/delete/<?=@$row->id?>/users','users<?=@$row->id?>')">delete</button></td>
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
<?php elseif($STEP == "addpermission"): ?>
<div class="message"><a href="<?=base_url()?>group/show/<?=$GROUPID?>">Back To Group</a></div>
        <form method="post">
        <table class="tbl" style="width:80%">
            <thead>
                <tr>
                    <td colspan="2">add new permission to this group</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Services Name</td>
                    <td>Permission</td>
                </tr>
                <?php foreach ($services as $key => $service): ?>
                    <tr> 
                        <td><?=$key?></td>
                        <td>
                            <?php foreach ($service as $value): ?>
                                <input type="checkbox" name="<?=$key?>_<?=$value?>" value="<?=$value?>" /><?=$value?>&nbsp;&nbsp;
                            <?php endforeach; ?>
                        </td>
                        </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2"><input type="submit" value="add" /></td>
                </tr>
            </tbody>
        </table>
        </form>
<?php elseif($STEP == "addusers"): ?>
<div class="message" id="add" style="display:none"></div>
<div class="message"><a href="<?=base_url()?>group/show/<?=$GROUPID?>">Back To Group</a></div>
        <table class="tbl" style="width:80%">
            <thead>
                <tr>
                    <td colspan="2">add new user to this group</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#</td>
                    <td>National ID</td>
                    <td>Name</td>
                    <td>select</td>
                </tr>
                <?php if($query):?>
                    <?php foreach ($query as $row): ?>
                        <?php if($row->group_id != $GROUPID):?>
                            <tr id="users<?=@$row->id?>">
                                <td><?=@$row->id?></td>
                                <td><?=@$row->idn?></td>
                                <td><?=@$row->en_name?></td>
                                <td><button onclick="added('<?=base_url()?>group/added/<?=@$row->id?>/<?=@$GROUPID?>','users<?=@$row->id?>')">Add</button></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <?php if($pagination) : ?>
            <div class="message"><?=$pagination?></div>
        <?php endif; ?>
<?php elseif($STEP == "add"): ?>
    <form method="post">
        <table class="tbl" style="width:80%">
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
        <table class="tbl" style="width:80%">
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
                    <td><?=$this->lang->line('group_location')?></td>
                    <td><input type="text" name="location" id="location" value="<?=@$LOCATION?>" /></td>
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
<div class="message">
    <?=$MSG?>
</div>
<?php endif; ?>

