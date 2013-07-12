<div class="message" id="candidate" style="display:none"></div>
<div class="message"><a href="<?=base_url()?>testament/download/candidate_users.csv">Download users who is candidate as CSV</a></div>
<div class="demo_jui">
    <table class="tbl" id="list" style="width:100%">
        <thead>
            <tr>
                <th colspan="6">list of Candidates</th>
            </tr>
            <tr>
                <th rowspan="2">#</th>
                <th rowspan="2">Name</th>
                <th colspan="3">Work Before</th>
                <th rowspan="2">Control</th>
            </tr>
            <tr>
                <th>2010</th>
                <th>2011</th>
                <th>2012</th>
            </tr>
        </thead>
        <tbody>
            <?php if($users):?>
                <?php foreach ($users as $row): ?>
                    <tr id="users<?=@$row->id?>">
                        <td><?=@$row->id?></td>
                        <td><?=@$row->en_name?></td>
                        <td><img src="<?=base_url()?>style/icon/<?=($this->users->checkIfWorkIn($row->users_id,2010))? "right.gif" : "del.png"?>" /></td>
                        <td><img src="<?=base_url()?>style/icon/<?=($this->users->checkIfWorkIn($row->users_id,2011))? "right.gif" : "del.png"?>" /></td>
                        <td><img src="<?=base_url()?>style/icon/<?=($this->users->checkIfWorkIn($row->users_id,2012))? "right.gif" : "del.png"?>" /></td>
                        <td>
                            <button id="users<?=@$row->id?>accept" onclick="candidate('<?=base_url()?>employee/candidate/0/accept/<?=@$row->id?>','users<?=@$row->id?>','accept')">Accept</button>
                            <button id="users<?=@$row->id?>reject" onclick="candidate('<?=base_url()?>employee/candidate/0/reject/<?=@$row->id?>','users<?=@$row->id?>','reject')">Reject</button>
                            <button id="users<?=@$row->id?>precau" onclick="candidate('<?=base_url()?>employee/candidate/0/precau/<?=@$row->id?>','users<?=@$row->id?>','precau')">Precaution</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php if($pagination) : ?>
    <div class="message"><?=$pagination?></div>
<?php endif; ?>
