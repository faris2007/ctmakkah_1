<?php if(@$STEP == "list") : ?>
<div class="message" id="candidate" style="display:none"></div>
<div class="message">If you want Search on user who don't have personal picture <a href="<?=base_url()?>employee/users/no_pic">Click Here</a></div>
<div class="message">If you want Search on user who have personal picture <a href="<?=base_url()?>employee/users/pic">Click Here</a></div>
<form method="post">
    <table class="tbl" style="width:80%">
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
                <td colspan="2"><input type="submit"  value="Add" /></td>
            </tr>
        </tbody>
    </table>
</form>

<table class="tbl" style="width:80%">
    <thead>
        <tr>
            <td colspan="4">list of Accepted Employee</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>#</td>
            <td>National ID</td>
            <td>Name</td>
            <td>Position</td>
            <td>mobile</td>
            <?/*--<td>Control</td>--> ?>*/?>
        </tr>
        <?php if($users):?>
            <?php foreach ($users as $row): ?>
                <tr id="users<?=@$row->id?>">
                    <td><?=@$row->contract_id?></td>
                    <td><?=@$row->idn?></td>
                    <td><?=@$row->en_name?></td>
                    <td><?=@$row->grade?></td>
                    <td><?=@$row->mobile?></td>
                    <? /*<td>
                        <button id="users<?=@$row->id?>accept" onclick="candidate('<?=base_url()?>employee/candidate/0/accept/<?=@$row->ide?>','users<?=@$row->id?>','accept')">Accept</button>
                        <button id="users<?=@$row->id?>reject" onclick="candidate('<?=base_url()?>employee/candidate/0/reject/<?=@$row->ide?>','users<?=@$row->id?>','reject')">Reject</button>
                        <button id="users<?=@$row->id?>precau" onclick="candidate('<?=base_url()?>employee/candidate/0/precau/<?=@$row->ide?>','users<?=@$row->id?>','precau')">Precaution</button>
                    </td> */?>
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
<?php elseif(@$STEP == "accept") : ?>
<div class="message"><a href="<?=base_url()?>employee/accepted">Back To Group</a></div>
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
