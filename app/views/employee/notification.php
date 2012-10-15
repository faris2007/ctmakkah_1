<?php if($STEP == "view"): ?>
<table class="tbl">
    <thead>
        <tr>
            <td colspan="4">List of notification</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>#</td>
            <td>for type</td>
            <td>to</td>
            <td>Control</td>
        </tr>
        <?php foreach($query as $row): ?>
        <tr>
            <td><?=$row->id?></td>
            <td><?=$row->to_type?></td>
            <td><?=(!is_bool($this->core->getInfoNotification($row->to_type,$row->to)))? $this->core->getInfoNotification($row->to_type,$row->to) : "NULL"?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php elseif($STEP == "add"): ?>

<?php elseif($STEP == "edit"): ?>

<?php endif; ?>
