<?php if(@$STEP == "view"): ?>
<div class="message" id="delete" style="display:none"></div>
    <?php if(@$ADMIN): ?>
        <br />
        <table class="tbl" id="listWork" style="width: 85%">
            <thead>
                <tr>
                    <td colspan="3">Table of Work</td>
                    <td><a href="<?=base_url()?>work/add/w"><img src="<?=base_url()?>style/icon/add.png" title="<?=$this->lang->line('icon_add')?>" /></a></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Date</td>
                    <td>Name</td>
                    <td>Location</td>
                    <td>Control</td>
                </tr>
                <?php if($WORK): ?>
                    <?php foreach ($WORK as $row): ?>
                        <tr id="work<?=$row->id?>">
                            <td><?=@date('Y-m-d',$row->date)?></td>
                            <td><?=@$row->name?></td>
                            <td><?=@$row->location?></td>
                            <td>
                                <a href="<?=base_url()?>work/edit/<?=$row->id?>"><img src="<?=base_url()?>style/icon/edit.png" title="<?=$this->lang->line('icon_edit')?>" /></a>
                                <a href="<?=base_url()?>work/show/<?=$row->id?>"><img src="<?=base_url()?>style/icon/show.png" title="<?=$this->lang->line('icon_show')?>" /></a>
                                <a onclick="deleted('<?=base_url()?>work/delete/<?=$row->id?>','work<?=$row->id?>','Not Found','listWork')" ><img src="<?=base_url()?>style/icon/del.png" title="<?=$this->lang->line('icon_del')?>" /></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Do not have any item yet</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <br />
        <table class="tbl" id="listTraining" style="width: 85%">
            <thead>
                <tr>
                    <td colspan="2">Table of Training</td>
                    <td><a href="<?=base_url()?>work/add/t"><img src="<?=base_url()?>style/icon/add.png" title="<?=$this->lang->line('icon_add')?>" /></a></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#</td>
                    <td>Name</td>
                    <td>Control</td>
                </tr>
                <?php if($TRAIN): ?>
                    <?php foreach ($TRAIN as $row): ?>
                        <tr id="work<?=$row->id?>">
                            <td><?=@$row->id?></td>
                            <td><?=@$row->name?></td>
                            <td>
                                <a href="<?=base_url()?>work/edit/<?=$row->id?>"><img src="<?=base_url()?>style/icon/edit.png" title="<?=$this->lang->line('icon_edit')?>" /></a>
                                <a href="<?=base_url()?>work/show/<?=$row->id?>"><img src="<?=base_url()?>style/icon/show.png" title="<?=$this->lang->line('icon_show')?>" /></a>
                                <a onclick="deleted('<?=base_url()?>work/delete/<?=$row->id?>','work<?=$row->id?>','Not Found','listTraining')" ><img src="<?=base_url()?>style/icon/del.png" title="<?=$this->lang->line('icon_del')?>" /></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Do not have any item yet</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <br />
        <table class="tbl" id="listTrail" style="width: 85%">
            <thead>
                <tr>
                    <td colspan="3">Table of Trail Operation</td>
                    <td><a href="<?=base_url()?>work/add/o"><img src="<?=base_url()?>style/icon/add.png" title="<?=$this->lang->line('icon_add')?>" /></a></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Date</td>
                    <td>Name</td>
                    <td>Location</td>
                    <td>Control</td>
                </tr>
                <?php if($TRAIL): ?>
                    <?php foreach ($TRAIL as $row): ?>
                        <tr id="work<?=$row->id?>">
                            <td><?=@date('Y-m-d',$row->date)?></td>
                            <td><?=@$row->name?></td>
                            <td><?=@$row->location?></td>
                            <td>
                                <a href="<?=base_url()?>work/edit/<?=$row->id?>"><img src="<?=base_url()?>style/icon/edit.png" title="<?=$this->lang->line('icon_edit')?>" /></a>
                                <a href="<?=base_url()?>work/show/<?=$row->id?>"><img src="<?=base_url()?>style/icon/show.png" title="<?=$this->lang->line('icon_show')?>" /></a>
                                <a onclick="deleted('<?=base_url()?>work/delete/<?=$row->id?>','work<?=$row->id?>','Not Found','listTrail')" ><img src="<?=base_url()?>style/icon/del.png" title="<?=$this->lang->line('icon_del')?>" /></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Do not have any item yet</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <br />
        <table class="tbl" id="listLive" style="width: 85%">
            <thead>
                <tr>
                    <td colspan="3">Table Of Live Exercise</td>
                    <td><a href="<?=base_url()?>work/add/l"><img src="<?=base_url()?>style/icon/add.png" title="<?=$this->lang->line('icon_add')?>" /></a></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Date</td>
                    <td>Name</td>
                    <td>Location</td>
                    <td>Control</td>
                </tr>
                <?php if($LIVE): ?>
                    <?php foreach ($LIVE as $row): ?>
                        <tr id="work<?=$row->id?>">
                            <td><?=@date('Y-m-d',$row->date)?></td>
                            <td><?=@$row->name?></td>
                            <td><?=@$row->location?></td>
                            <td>
                                <a href="<?=base_url()?>work/edit/<?=$row->id?>"><img src="<?=base_url()?>style/icon/edit.png" title="<?=$this->lang->line('icon_edit')?>" /></a>
                                <a href="<?=base_url()?>work/show/<?=$row->id?>"><img src="<?=base_url()?>style/icon/show.png" title="<?=$this->lang->line('icon_show')?>" /></a>
                                <a onclick="deleted('<?=base_url()?>work/delete/<?=$row->id?>','work<?=$row->id?>','Not Found','listLive')" ><img src="<?=base_url()?>style/icon/del.png" title="<?=$this->lang->line('icon_del')?>" /></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Do not have any item yet</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <br />
    <?php else: ?>
            <table class="tbl1" style="width: 85%">
                <thead>
                    <tr>
                        <td colspan="2">Training Table</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Name</td>
                        <td>Table Pictures</td>
                    </tr>
                    <?php if(@$TRAIN): ?>
                        <?php foreach($TRAIN as $row): ?>
                            <tr>
                                <td><?=$row->name?></td>
                                <td><a rel="prettyPhoto[gallery1]" href="<?=@$row->table?>"><img src="<?=@$row->table?>" style="width:100px;height:100px" alt="<?=$row->name?>" /></a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2">Do not have any tables yet</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <br />
            <table class="tbl1" style="width: 85%">
                <thead>
                    <tr>
                        <td colspan="4">Table of works</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Date</td>
                        <td>Location</td>
                        <td>Type</td>
                        <td>Start Time</td>
                        <td>End Time</td>
                    </tr>
                    <?php if(@$tables): ?>
                        <?php foreach($tables as $row): ?>
                            <tr>
                                <td><?=@date('Y-m-d',$row->date)?></td>
                                <td><?=@$row->location?></td>
                                <td><?=@$this->core->getNameOfTableType($row->isTraning)?></td>
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
                <?php if($ISNOTTRAIN): ?>
                <tr>
                    <td>Date : </td>
                    <td><input type="text" name="date" class="styleDate" /></td>
                </tr>
                <tr>
                    <td>Location : </td>
                    <td><input type="text" name="location" /></td>
                </tr>
                <tr>
                    <td>Start Time : </td>
                    <td>
                        <select name="start_hour">
                            <?php for($i=1;$i<13;$i++): ?>
                                <option value="<?=str_pad($i, 2, "0", STR_PAD_LEFT)?>"><?=str_pad($i, 2, "0", STR_PAD_LEFT)?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="start_min">
                            <?php for($i=0;$i<60;$i++): ?>
                                <option value="<?=str_pad($i, 2, "0", STR_PAD_LEFT)?>"><?=str_pad($i, 2, "0", STR_PAD_LEFT)?></option>
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
                <?php endif; ?>
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
                <?php if($ISNOTTRAIN): ?>
                <tr>
                    <td>Date : </td>
                    <td><input type="text" name="date" class="styleDate" value="<?=@$DATE?>" /></td>
                </tr>
                <tr>
                    <td>Location : </td>
                    <td><input type="text" name="location" value="<?=$LOCATION?>" /></td>
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
                <?php endif;?>
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
            <?php if(!$ISTRAINING): ?>
            <tr>
                <td>DATE : </td>
                <td><?=@$DATE?></td>
            </tr>
            <?php endif; ?>
            <tr>
                <td>Name : </td>
                <td><?=@$NAME?></td>
            </tr>
            <?php if(!$ISTRAINING): ?>
            <tr>
                <td>Location : </td>
                <td><?=@$LOCATION?></td>
            </tr>
            <tr>
                <td>Time : </td>
                <td>From <?=@$START?> To <?=@$END?></td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <br />
    <table class="tbl"  style="width:85%">
        <thead>
            <tr>
                <td colspan="2">Search on users if he is here or not</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>National ID :</td>
                <td><input type="text" id="idn" name="idn" placeholder="ID .." /></td>
            </tr>
            <tr>
                <td colspan="2"><button onclick="Search('<?=base_url()?>work/show/<?=@$ID?>/search','delete');">Search</button></td>
            </tr>
        </tbody>
    </table>
    <br />
    <form method="post"<?php if($ISTRAINING): ?> enctype="multipart/form-data"<?php endif;?>>
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
                <?php if($ISTRAINING): ?>
                    <tr>
                        <td>Upload Table : </td>
                        <td><input type="file" name="tablepic" /></td>
                    </tr>
                <?php endif; ?>
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

