<?php if($STEP == "view"): ?>
<div id="delete" class="tbl" style="color:white;background-color:red;display:none;width:50%;text-align:center" ></div>
    <table class="tbl" id="list" style="width:80%">
        <thead>
            <tr>
                <td colspan="3"><?=$this->lang->line('attendance_view')?></td>
                <?php if(@$CONTROL): ?>
                    <td><a href="<?=base_url()?>attendance/add"><img src="<?=base_url()?>style/icon/add.png" title="<?=$this->lang->line('icon_add')?>" /></a></td>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>#</td>
                <td><?=$this->lang->line('attendance_view_name')?></td>
                <td><?=$this->lang->line('attendance_view_superviser')?></td>
                <?php if(@$CONTROL): ?>
                    <td><?=$this->lang->line('attendance_view_control')?></td>
                <?php endif; ?>
            </tr>
            <?php if($query) : ?>
                <?php foreach(@$query as $row): ?>
                    <tr id="attendances<?=$row->id?>">
                        <td><?=$row->id?></td>
                        <td><?=$row->name?></td>
                        <td><?php
                                if($row->superviser != NULL){
                                    $userinfo = $this->users->get_info_user("all",$row->superviser);
                                    echo $userinfo['profile']->en_name;
                                }else
                                    echo "Nothing";
                            ?></td>
                        <?php if(@$CONTROL): ?>
                        <td>
                            <a href="<?=base_url()?>attendance/edit/<?=$row->id?>"><img src="<?=base_url()?>style/icon/edit.png" title="<?=$this->lang->line('icon_edit')?>" /></a>
                            <a href="<?=base_url()?>attendance/show/<?=$row->id?>"><img src="<?=base_url()?>style/icon/show.png" title="<?=$this->lang->line('icon_show')?>" /></a>
                            <a onclick="deleted('<?=base_url()?>attendance/delete/<?=$row->id?>','attendances<?=$row->id?>','<?=$this->lang->line("attendance_view_nothing")?>')" ><img src="<?=base_url()?>style/icon/del.png" title="<?=$this->lang->line('icon_del')?>" /></a>
                        </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                    <tr>
                        <td colspan="<?=(@$CONTROL)?4:3?>"><?=$this->lang->line('attendance_view_nothing')?></td>
                    </tr>
            <?php endif; ?>
        </tbody>
    </table>
<?php elseif($STEP == "show"): ?>
<div class="message" id="delete" style="display:none"></div>
<table class="tbl" style="width:80%">
    <thead>
        <tr>
            <td colspan="2"><?=$this->lang->line('attendance_edit')?></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?=$this->lang->line('attendance_name')?></td>
            <td><input type="text" name="name" id="name" value="<?=@$NAME?>" disabled="1" /></td>
        </tr>
        <tr>
            <td><?=$this->lang->line('attendance_superviser')?></td>
            <td><input type="text" name="location" id="location" value="<?=@$SUPERVISER?>" disabled="1" /></td>
        </tr>
    </tbody>
</table>
<br />
<div class="message">
    groups in this attendance if you want add new group to this attendance <a href="<?=base_url()?>attendance/addgrouptoattend/<?=@$ID?>">click here</a>
</div>
        <table class="tbl" style="width:80%">
            <thead>
                <tr>
                    <td colspan="2">group in this attendance</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#</td>
                    <td>Name</td>
                    <td>Remove</td>
                </tr>
                <?php if(@$groups):?>
                    <?php foreach ($groups as $row): ?>
                        <tr id="groups<?=@$row->id?>">
                            <td><?=@$row->id?></td>
                            <td><?=@$row->name?></td>
                            <td><button onclick="deleted('<?=base_url()?>attendance/delete/<?=@$row->id?>/group','groups<?=@$row->id?>')">Remove</button></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                        <tr>
                            <td colspan="4">Not Found</td>
                        </tr>
                <?php endif; ?>
            </tbody>
        </table>
<?php elseif($STEP == "addgroups"): ?>
<div class="message" id="add" style="display:none"></div>
<div class="message"><a href="<?=base_url()?>attendance/show/<?=$ID?>">Back To attendance</a></div>
        <table class="tbl" style="width:80%">
            <thead>
                <tr>
                    <td colspan="4">add new Group to this attendance</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#</td>
                    <td>Name</td>
                    <td>select</td>
                </tr>
                <?php if($query):?>
                    <?php foreach ($query as $row): ?>
                        <tr id="groups<?=@$row->id?>">
                            <td><?=@$row->id?></td>
                            <td><?=@$row->name?></td>
                            <td><button onclick="added('<?=base_url()?>attendance/added/<?=@$row->id?>/<?=@$ID?>','groups<?=@$row->id?>')">Add</button></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
<?php elseif($STEP == "add"): ?>
    <form method="post">
        <table class="tbl" style="width:80%">
            <thead>
                <tr>
                    <td colspan="2"><?=$this->lang->line('attendance_add')?></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$this->lang->line('attendance_name')?></td>
                    <td><input type="text" name="name" id="name" /></td>
                </tr>
                <tr>
                    <td><?=$this->lang->line('attendance_superviser')?></td>
                    <td>
                        <select name="superviser">
                            <option value="0">Nothing</option>
                            <?php if(@$query): ?>
                                <?php foreach($query as $row): ?>
                                    <option value="<?=$row->id?>"><?=$row->en_name?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </td>
                </tr>
                <?php if(@$ERROR): ?>
                    <tr>
                        <td colspan="2"><?=$this->lang->line('attendance_add_error')?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td colspan="2"><input type="submit" value="<?=$this->lang->line('attendance_button_add')?>"/></td>
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
                    <td colspan="2"><?=$this->lang->line('attendance_edit')?></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$this->lang->line('attendance_name')?></td>
                    <td><input type="text" name="name" id="name" value="<?=@$NAME?>" /></td>
                </tr>
                <tr>
                    <td><?=$this->lang->line('attendance_superviser')?></td>
                    <td>
                        <select name="superviser">
                            <option value="0">Nothing</option>
                            <?php if($query): ?>
                                <?php foreach($query as $row): ?>
                            <option<?=(@$SUPERVISER == $row->id)?' selected="true"':''?> value="<?=$row->id?>"><?=$row->en_name?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </td>
                </tr>
                <?php if(@$ERROR): ?>
                    <tr>
                        <td colspan="2"><?=$this->lang->line('attendance_add_error')?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td colspan="2"><input type="submit" value="<?=$this->lang->line('attendance_button_edit')?>"/></td>
                </tr>
            </tbody>
        </table>
    </form>
<?php elseif($STEP == "attend"): ?>
<table class="tbl" style="width:80%">
    <thead>
        <tr>
            <td colspan="2">Start Attendance</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Select Group :</td>
            <td>
                <select name="group" id="group">
                    <option disabled="true">Select Group</option>
                <?php if(@$query): ?>
                    <?php foreach($query as $row): ?>
                        <option value="<?=$row->id?>"><?=$row->name?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Select Action :</td>
            <td>
                <select name="action" id="action">
                    <option disabled="true">Select Action</option>
                    <option value="take">Start Attendance</option>
                    <option value="report">Report</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><button onclick="StartAction('<?=base_url()?>')">Start</button></td>
        </tr>
    </tbody>
</table>
<?php elseif($STEP == "take"): ?>
<div class="message"><a href="<?=base_url()?>attendance/takeAttendance">Back To attendance</a></div>
<div class="message" id="add" style="display:none"></div>
<table class="tbl" style="width:80%">
    <thead>
        <tr>
            <td colspan="2">Take Attendance</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Name Employee </td>
            <?php if(@$attend): ?>
                <?php foreach($attend as $row): ?>
                    <td><?=$row->date?></td>
                <?php endforeach; ?>
            <?php endif; ?>
        </tr>
        <?php if(@$users): ?>
            <?php foreach($users as $user): ?>
                <tr>
                    <td><?=$user->en_name?></td>
                    <?php if(@$attend): ?>
                        <?php foreach($attend as $row): ?>
                            <td id="attend<?=$row->id?>">
                                <?php if($row->id == $attendTodayId): ?>
                                    <?php if($this->attendances->getAttendanceSheet($user->id,$row->id)): ?>
                                        <img src="<?=base_url()?>style/icon/<?=(!$this->attendances->getAttendanceSheet($user->id,$row->id))? "del.png" : "right.gif"?>" />
                                    <?php else: ?>
                                        <button onclick="attendance('<?=base_url()?>attendance/added/<?=@$user->id?>/<?=@$attendTodayId?>/attend','attend<?=$row->id?>','<?=base_url()?>')">attendance</button>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <img src="<?=base_url()?>style/icon/<?=(!$this->attendances->getAttendanceSheet($user->id,$row->id))? "del.png" : "right.gif"?>" />
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<?php elseif($STEP == "report"): ?>
<div class="message"><a href="<?=base_url()?>attendance/takeAttendance">Back To attendance</a></div>
<div class="message" id="add" style="display:none"></div>
<table class="tbl" style="width:80%">
    <thead>
        <tr>
            <td colspan="2">Take Attendance</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Name Employee </td>
            <?php if(@$attend): ?>
                <?php foreach($attend as $row): ?>
                    <td><?=$row->date?></td>
                <?php endforeach; ?>
            <?php endif; ?>
        </tr>
        <?php if(@$users): ?>
            <?php foreach($users as $user): ?>
                <tr>
                    <td><?=$user->en_name?></td>
                    <?php if(@$attend): ?>
                        <?php foreach($attend as $row): ?>
                            <td id="attend<?=$row->id?>">
                                <img src="<?=base_url()?>style/icon/<?=(!$this->attendances->getAttendanceSheet($user->id,$row->id))? "del.png" : "right.gif"?>" />
                            </td>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<?php elseif($STEP == "success"): ?>
<div class="message">
    <?=$MSG?>
</div>
<?php endif; ?>

