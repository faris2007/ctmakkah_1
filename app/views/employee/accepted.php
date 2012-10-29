<?php if(@$STEP == "list") : ?>
<div class="message" id="candidate" style="display:none"></div>
<div class="message">If you want Search on user who don't have personal picture <a href="<?=base_url()?>employee/users/no_pic">Click Here</a></div>
<div class="message">If you want Search on user who have personal picture <a href="<?=base_url()?>employee/users/pic">Click Here</a></div>
<form method="post">
    <table class="tbl" style="width:95%">
        <thead>
            <tr>
                <td colspan="2">Accept Employees</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Nationals ID :</td>
                <td><textarea name="IDNS" style="width:80%"></textarea></td>
            </tr>
            <tr>
                <td>Change Jobs</td>
                <td>
                    <select name="jobs">
                        <option selected="selected" value="0">None</option>
                        <?php if(@$jobs): ?>
                            <?php foreach(@$jobs as $row): ?>
                            <option value="<?=$row->id?>"><?=$row->name?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Accept Action</td>
                <td>
                    <select name="action">
                        <option selected="selected" value="add">add as new accepted</option>
                        <option value="change">reject all before</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="add"  value="Add" />&nbsp;<input type="submit" name="check"  value="Check" /></td>
            </tr>
        </tbody>
    </table>
</form>
<br />
<table class="tbl" style="width:95%">
    <thead>
        <tr>
            <td colspan="2">Search if the user is accepted</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>ID National:</td>
            <td><input type="text" id="idn" placeholder="ID ..." /></td>
        </tr>
        <tr>
            <td colspan="2"><button onclick="Search('<?=base_url()?>employee/accepted/0/search','candidate')">Search</button></td>
        </tr>
    </tbody>
</table>
<br />
<div class="demo_jui">
<table class="tbl" id="list" dataajax="accepted" style="width:100%">
    <thead>
        <tr>
            <th colspan="5">list of Accepted Employee</th>
        </tr>
        <tr>
            <th>#</th>
            <th>National ID</th>
            <th>Name</th>
            <th>Position</th>
            <th>mobile</th>
            <th>Control</th>
            <?/*--<td>Control</td>--> ?>*/?>
        </tr>
    </thead>
    <tbody>
        <?php if(!$users):?>
            <?php foreach ($users as $row): ?>
                <tr id="users<?=@$row->id?>">
                    <td><?=@$row->contract_id?></td>
                    <td><?=@$row->idn?></td>
                    <td><?=@$row->en_name?></td>
                    <td><?=@$row->grade?></td>
                    <td><?=@$row->mobile?></td>
                    <td>
                        <a href="<?=base_url()?>employee/profile/<?=$row->idn?>"><img src="<?=base_url()?>style/icon/edit.png" title="<?=$this->lang->line('icon_edit')?>" /></a>
                    </td>
                    <? /*<td>
                        <button id="users<?=@$row->id?>accept" onclick="candidate('<?=base_url()?>employee/candidate/0/accept/<?=@$row->ide?>','users<?=@$row->id?>','accept')">Accept</button>
                        <button id="users<?=@$row->id?>reject" onclick="candidate('<?=base_url()?>employee/candidate/0/reject/<?=@$row->ide?>','users<?=@$row->id?>','reject')">Reject</button>
                        <button id="users<?=@$row->id?>precau" onclick="candidate('<?=base_url()?>employee/candidate/0/precau/<?=@$row->ide?>','users<?=@$row->id?>','precau')">Precaution</button>
                    </td> */?>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
</div>
<?php if($pagination) : ?>
    <div class="message"><?=$pagination?></div>
<?php endif; ?>
<?php elseif(@$STEP == "accept") : ?>
<div class="message"><a href="<?=base_url()?>employee/accepted">Back To Accepted list</a></div>
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
