<div class="message" id="candidate" style="display:none"></div>
<div class="demo_jui">
    <table class="tbl" id="list" style="width:100%">
        <thead>
            <tr>
                <th colspan="4">list of Rejected Employee</th>
            </tr>
            <tr>
                <th>#</th>
                <th>National ID</th>
                <th>Name</th>
                <th>Control</th>
            </tr>
        </thead>
        <tbody>
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
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php if($pagination) : ?>
    <div class="message"><?=$pagination?></div>
<?php endif; ?>
