<?php if($STEP == "view"): ?>
<div id="delete" class="tbl" style="color:white;background-color:red;display:none;width:50%;text-align:center" ></div>
<table class="tbl" id="penaltyType" style="width:85%">
    <thead>
        <tr>
            <td colspan="3">List for type of penalty</td>
            <td><a href="<?=base_url()?>penalty/add/type"><img src="<?=base_url()?>style/icon/add.png" title="<?=$this->lang->line('icon_add')?>" /></a></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>#</td>
            <td>Name</td>
            <td>Amount Of Penalty</td>
            <td>Control</td>
        </tr>
        <?php if(@$types): ?>
            <?php foreach ($types as $row):?>
                <tr id="penaltyT<?=@$row->id?>">
                    <td><?=@$row->id?></td>
                    <td><?=@$row->name?></td>
                    <td><?=@$row->penaltyAmount?></td>
                    <td>
                        <a href="<?=base_url()?>penalty/edit/type/<?=$row->id?>"><img src="<?=base_url()?>style/icon/edit.png" title="<?=$this->lang->line('icon_edit')?>" /></a>
                        <a onclick="deleted('<?=base_url()?>penalty/delete/type/<?=$row->id?>','penaltyT<?=@$row->id?>','NOT FOUND','penaltyType')" ><img src="<?=base_url()?>style/icon/del.png" title="<?=$this->lang->line('icon_del')?>" /></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="4">Not Found any type yet</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<br />
<table class="tbl" id="penalty" style="width:85%">
    <thead>
        <tr>
            <td colspan="4">List for penalty</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>#</td>
            <td>Name of user</td>
            <td>Type of penalty</td>
            <td>Control</td>
        </tr>
        <?php if(@$penalty): ?>
            <?php foreach ($penalty as $row):?>
                <tr id="penalty<?=@$row->id?>">
                    <td><?=@$row->id?></td>
                    <td><?=@$row->en_name?></td>
                    <td><?=@$row->name?></td>
                    <td>
                        <a href="<?=base_url()?>penalty/edit/penalty/<?=$row->id?>"><img src="<?=base_url()?>style/icon/edit.png" title="<?=$this->lang->line('icon_edit')?>" /></a>
                        <a onclick="deleted('<?=base_url()?>penalty/delete/penalty/<?=$row->id?>','penalty<?=@$row->id?>','NOT FOUND','penalty')" ><img src="<?=base_url()?>style/icon/del.png" title="<?=$this->lang->line('icon_del')?>" /></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="4">Not Found any type yet</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php elseif ($STEP == "addType"): ?>
<form method="post">
    <table class="tbl" style="width:85%">
        <thead>
            <tr>
                <td colspan="2">Add new type of penalty</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Name :</td>
                <td><input type="text" name="name" /></td>
            </tr>
            <tr>
                <td>Length :</td>
                <td><input type="text" name="length" /></td>
            </tr>
            <tr>
                <td>Amount Of penalty :</td>
                <td><input type="text" name="amount" /></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Add" /></td>
            </tr>
            <?php if(@$ERROR):?>
                <tr>
                    <td colspan="2">there is error in data entry</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</form>
<?php elseif ($STEP == "addPenalty"): ?>
<form method="post">
    <table class="tbl" style="width:85%">
        <thead>
            <tr>
                <td colspan="2">Add new penalty for <?=@$USER_NAME?></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Type of penalty</td>
                <td>
                    <select name="type">
                        <option value="0">Select Type</option>
                        <?php if(@$types): ?>
                            <?php foreach ($types as $row):?>
                                <option value="<?=$row->id?>"><?=$row->name?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Date :</td>
                <td><input type="text" name="date" placeholder="DD/MM/YYYY" /></td>
            </tr>
            <tr>
                <td>Time :</td>
                <td>
                    <select name="time_hour">
                        <?php for($i=1;$i<13;$i++): ?>
                            <option value="<?=str_pad($i, 2, "0", STR_PAD_LEFT)?>"><?=str_pad($i, 2, "0", STR_PAD_LEFT)?></option>
                        <?php endfor; ?>
                    </select>
                    <select name="time_min">
                        <?php for($i=0;$i<60;$i++): ?>
                            <option value="<?=str_pad($i, 2, "0", STR_PAD_LEFT)?>"><?=str_pad($i, 2, "0", STR_PAD_LEFT)?></option>
                        <?php endfor; ?>
                    </select>
                    <select name="time_am">
                        <option value="am">AM</option>
                        <option value="pm">PM</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Note :</td>
                <td>
                    <textarea name="note" style="width:95%"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Add" /></td>
            </tr>
            <?php if(@$ERROR):?>
                <tr>
                    <td colspan="2">there is error in data entry</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</form>
<?php elseif ($STEP == "editType"): ?>
<form method="post">
    <table class="tbl" style="width:85%">
        <thead>
            <tr>
                <td colspan="2">Edit type of penalty</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Name :</td>
                <td><input type="text" name="name" value="<?=@$NAME?>" /></td>
            </tr>
            <tr>
                <td>Length :</td>
                <td><input type="text" name="length" value="<?=@$LENGTH?>" /></td>
            </tr>
            <tr>
                <td>Amount Of penalty :</td>
                <td><input type="text" name="amount" value="<?=@$AMOUNT?>" /></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Edit" /></td>
            </tr>
            <?php if(@$ERROR):?>
                <tr>
                    <td colspan="2">there is error in data entry</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</form>
<?php elseif ($STEP == "editPenalty"): ?>
<form method="post">
    <table class="tbl" style="width:85%">
        <thead>
            <tr>
                <td colspan="2">Add new penalty for <?=@$USER_NAME?></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Type of penalty</td>
                <td>
                    <select name="type">
                        <option value="0">Select Type</option>
                        <?php if(@$types): ?>
                            <?php foreach ($types as $row):?>
                                <option<?=(@$TYPE == $row->id)?' selected="selected"':''?> value="<?=$row->id?>"><?=$row->name?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Date :</td>
                <td><input type="text" name="date" placeholder="DD/MM/YYYY" value="<?=@$DATE?>" /></td>
            </tr>
            <tr>
                <td>Time :</td>
                <td>
                    <select name="time_hour">
                        <?php for($i=1;$i<13;$i++): ?>
                            <option<?=(@$TIME_HOUR == str_pad($i, 2, "0", STR_PAD_LEFT))?' selected="selected"':''?> value="<?=str_pad($i, 2, "0", STR_PAD_LEFT)?>"><?=str_pad($i, 2, "0", STR_PAD_LEFT)?></option>
                        <?php endfor; ?>
                    </select>
                    <select name="time_min">
                        <?php for($i=0;$i<60;$i++): ?>
                            <option<?=(@$TIME_MIN == str_pad($i, 2, "0", STR_PAD_LEFT))?' selected="selected"':''?> value="<?=str_pad($i, 2, "0", STR_PAD_LEFT)?>"><?=str_pad($i, 2, "0", STR_PAD_LEFT)?></option>
                        <?php endfor; ?>
                    </select>
                    <select name="time_am">
                        <option<?=(@$TIME_AM == 'am')?' selected="selected"':''?> value="am">AM</option>
                        <option<?=(@$TIME_AM == 'pm')?' selected="selected"':''?> value="pm">PM</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Note :</td>
                <td>
                    <textarea name="note" style="width:95%"><?=@$NOTE?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Edit" /></td>
            </tr>
            <?php if(@$ERROR):?>
                <tr>
                    <td colspan="2">there is error in data entry</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</form>
<?php elseif($STEP == "success"): ?>
<div class="message">
    <?=$MSG?>
</div>
<?php endif; ?>
