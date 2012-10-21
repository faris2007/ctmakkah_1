<?php if(@$STEP == "view"): ?>
<div class="message" id="delete" style="display:none"></div>
    <?php if(@$ADMIN): ?>
        <br />
        <?php for($i=7;$i<=13;$i++):?>
            <table class="tbl" id="list<?=$i?>" style="width: 85%">
                <thead>
                    <tr>
                        <td colspan="3">list of group work in the day <?=$i?>th</td>
                        <td><a href="<?=base_url()?>work/add/<?=$i?>"><img src="<?=base_url()?>style/icon/add.png" title="<?=$this->lang->line('icon_add')?>" /></a></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#</td>
                        <td>Name</td>
                        <td>Location</td>
                        <td>Control</td>
                    </tr>
                    <?php if($days[$i]): ?>
                        <?php foreach ($days[$i] as $row): ?>
                            <tr id="work<?=$row->id?>">
                                <td><?=@$row->id?></td>
                                <td><?=@$row->name?></td>
                                <td><?=@$row->location?></td>
                                <td>
                                    <a href="<?=base_url()?>work/edit/<?=$row->id?>"><img src="<?=base_url()?>style/icon/edit.png" title="<?=$this->lang->line('icon_edit')?>" /></a>
                                    <a href="<?=base_url()?>work/show/<?=$row->id?>"><img src="<?=base_url()?>style/icon/show.png" title="<?=$this->lang->line('icon_show')?>" /></a>
                                    <a onclick="deleted('<?=base_url()?>work/delete/<?=$row->id?>','work<?=$row->id?>','Not Found','list<?=$i?>')" ><img src="<?=base_url()?>style/icon/del.png" title="<?=$this->lang->line('icon_del')?>" /></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">Do not have any group yet</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <br />
        <?php endfor; ?>
    <?php else: ?>
            <table class="tbl" style="width: 85%">
                <thead>
                    <tr>
                        <td colspan="4">Table of works</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Day</td>
                        <td>Location</td>
                        <td>Start Time</td>
                        <td>End Time</td>
                    </tr>
                    <?php if(isset($tables)): ?>
                        <?php foreach($tables as $row): ?>
                            <tr>
                                <td><?=@$row->day?>th</td>
                                <td><?=@$row->location?></td>
                                <td><?=@$row->startTime?></td>
                                <td><?=@$row->endTime?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">Do not have any tables yet</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
    <?php endif; ?>
<?php elseif (@$STEP == "add") :?>
    <form method="post">
        <table class="tbl" style="width:85%">
            <thead>
                <tr>
                    <td colspan="2">Add new Work Group</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Name : </td>
                    <td><input type="text" name="name" /></td>
                </tr>
                <tr>
                    <td>Location : </td>
                    <td>
                        <select name="location">
                            <option value="Mina1">Mina1</option>
                            <option value="Mina2">Mina2</option>
                            <option value="Mina3">Mina3</option>
                            <option value="Arafat1">Arafat1</option>
                            <option value="Arafat2">Arafat2</option>
                            <option value="Arafat3">Arafat3</option>
                            <option value="Muzdalifah1">Muzdalifah1</option>
                            <option value="Muzdalifah2">Muzdalifah2</option>
                            <option value="Muzdalifah3">Muzdalifah3</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Start Time : </td>
                    <td>
                        <select name="start_hour">
                            <?php for($i=1;$i<13;$i++): ?>
                                <option value="<?=$i?>"><?=$i?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="start_min">
                            <?php for($i=0;$i<60;$i++): ?>
                                <option value="<?=$i?>"><?=$i?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="start_am">
                            <option value="am">AM</option>
                            <option value="pm">PM</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>End Time : </td>
                    <td>
                        <select name="end_hour">
                            <?php for($i=1;$i<13;$i++): ?>
                                <option value="<?=str_pad($i, 2, "0", STR_PAD_LEFT)?>"><?=str_pad($i, 2, "0", STR_PAD_LEFT)?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="end_min">
                            <?php for($i=0;$i<60;$i++): ?>
                                <option value="<?=str_pad($i, 2, "0", STR_PAD_LEFT)?>"><?=str_pad($i, 2, "0", STR_PAD_LEFT)?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="end_am">
                            <option value="am">AM</option>
                            <option value="pm">PM</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="Add" /></td>
                </tr>
                <?php if(@$ERROR): ?>
                    <tr>
                        <td colspan="2">there is error in data entry</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </form>
<?php elseif (@$STEP == "edit"): ?>
    <form method="post">
        <table class="tbl" style="width:85%">
            <thead>
                <tr>
                    <td colspan="2">Edit Work Group</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Name : </td>
                    <td><input type="text" name="name" value="<?=@$NAME?>" /></td>
                </tr>
                <tr>
                    <td>Location : </td>
                    <td>
                        <select name="location">
                            <option<?=(@$LOCATION == 'Mina1')?' selected="selected"':''?> value="Mina1">Mina1</option>
                            <option<?=(@$LOCATION == 'Mina2')?' selected="selected"':''?> value="Mina2">Mina2</option>
                            <option<?=(@$LOCATION == 'Mina3')?' selected="selected"':''?> value="Mina3">Mina3</option>
                            <option<?=(@$LOCATION == 'Arafat1')?' selected="selected"':''?> value="Arafat1">Arafat1</option>
                            <option<?=(@$LOCATION == 'Arafat2')?' selected="selected"':''?> value="Arafat2">Arafat2</option>
                            <option<?=(@$LOCATION == 'Arafat3')?' selected="selected"':''?> value="Arafat3">Arafat3</option>
                            <option<?=(@$LOCATION == 'Muzdalifah1')?' selected="selected"':''?> value="Muzdalifah1">Muzdalifah1</option>
                            <option<?=(@$LOCATION == 'Muzdalifah2')?' selected="selected"':''?> value="Muzdalifah2">Muzdalifah2</option>
                            <option<?=(@$LOCATION == 'Muzdalifah3')?' selected="selected"':''?> value="Muzdalifah3">Muzdalifah3</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Start Time : </td>
                    <td>
                        <select name="start_hour">
                            <?php for($i=1;$i<13;$i++): ?>
                            <option<?=(@$START_HOUR == str_pad($i, 2, "0", STR_PAD_LEFT))?' selected="selected"':''?> value="<?=str_pad($i, 2, "0", STR_PAD_LEFT)?>"><?=str_pad($i, 2, "0", STR_PAD_LEFT)?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="start_min">
                            <?php for($i=0;$i<60;$i++): ?>
                                <option<?=(@$START_MIN == str_pad($i, 2, "0", STR_PAD_LEFT))?' selected="selected"':''?> value="<?=str_pad($i, 2, "0", STR_PAD_LEFT)?>"><?=str_pad($i, 2, "0", STR_PAD_LEFT)?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="start_am">
                            <option<?=(@$START_AM == 'am')?' selected="selected"':''?> value="am">AM</option>
                            <option<?=(@$START_AM == 'pm')?' selected="selected"':''?> value="pm">PM</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>End Time : </td>
                    <td>
                        <select name="end_hour">
                            <?php for($i=1;$i<13;$i++): ?>
                                <option<?=(@$END_HOUR == str_pad($i, 2, "0", STR_PAD_LEFT))?' selected="selected"':''?> value="<?=str_pad($i, 2, "0", STR_PAD_LEFT)?>"><?=str_pad($i, 2, "0", STR_PAD_LEFT)?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="end_min">
                            <?php for($i=0;$i<60;$i++): ?>
                                <option<?=(@$END_MIN == str_pad($i, 2, "0", STR_PAD_LEFT))?' selected="selected"':''?> value="<?=str_pad($i, 2, "0", STR_PAD_LEFT)?>"><?=str_pad($i, 2, "0", STR_PAD_LEFT)?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="end_am">
                            <option<?=(@$END_AM == 'am')?' selected="selected"':''?> value="am">AM</option>
                            <option<?=(@$END_AM == 'pm')?' selected="selected"':''?> value="pm">PM</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="Edit" /></td>
                </tr>
                <?php if(@$ERROR): ?>
                    <tr>
                        <td colspan="2">there is error in data entry</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </form>
<?php elseif (@$STEP == "show"): ?>
    <div class="message" id="delete" style="display:none"></div>
    <table class="tbl" style="width: 85%">
        <thead>
            <tr>
                <td colspan="2">Information about this Group of work</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Name : </td>
                <td><?=@$NAME?></td>
            </tr>
            <tr>
                <td>Location : </td>
                <td><?=@$LOCATION?></td>
            </tr>
            <tr>
                <td>Time : </td>
                <td>From <?=@$START?> To <?=@$END?></td>
            </tr>
        </tbody>
    </table>
    <br />
    <form method="post">
        <table class="tbl" style="width:85%">
            <thead>
                <tr>
                    <td colspan="2">add new user to this group</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>National ID :</td>
                    <td><textarea name="IDNS" style="width:80%"></textarea></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit"  value="Add" /></td>
                </tr>
            </tbody>
        </table>
    </form>
    <table class="tbl" id="list" style="width:85%">
        <thead>
            <tr>
                <td colspan="4">add new user to this group</td>
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
                        <td><button onclick="deleted('<?=base_url()?>work/delete/<?=@$ID?>/users/<?=@$row->id?>','users<?=@$row->id?>')">delete</button></td>
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
<?php elseif (@$STEP == "success"): ?>
    <div class="message"><?=@$MSG?></div>
<?php elseif (@$STEP == "adduser"): ?>
    <div class="message"><a href="<?=base_url()?>work/show/<?=$WORKID?>">Back To Group of Work</a></div>
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
<?php endif; ?>

