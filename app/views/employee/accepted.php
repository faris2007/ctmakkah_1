<div class="message" id="candidate" style="display:none"></div>
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
            <td>Control</td>
        </tr>
        <?php if($users):?>
            <?php foreach ($users as $row): ?>
                <tr id="users<?=@$row->id?>">
                    <td><?=@$row->id?></td>
                    <td><?=@$row->idn?></td>
                    <td><?=@$row->en_name?></td>
                    <td>
                        <button id="users<?=@$row->id?>accept" onclick="candidate('<?=base_url()?>employee/candidate/0/accept/<?=@$row->id?>','users<?=@$row->id?>','accept')">Accept</button>
                        <button id="users<?=@$row->id?>reject" onclick="candidate('<?=base_url()?>employee/candidate/0/reject/<?=@$row->id?>','users<?=@$row->id?>','reject')">Reject</button>
                        <button id="users<?=@$row->id?>precau" onclick="candidate('<?=base_url()?>employee/candidate/0/precau/<?=@$row->id?>','users<?=@$row->id?>','precau')">Precaution</button>
                    </td>
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
