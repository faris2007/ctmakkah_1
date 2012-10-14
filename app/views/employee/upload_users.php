<?php if(@$STEP == "upload"): ?>
<form method="post" enctype="multipart/form-data" action="<?=base_url()?>employee/uploadusers">
    <table class="tbl">
        <thead>
            <tr>
                <td colspan="2">Upload users from csv file</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Select File (less than 4 MB) :</td>
                <td><input type="file" name="userfile" /></td>
            </tr>
            <tr>
                <td>Select Type Of users :</td>
                <td>
                    <select name="is_old">
                        <option value="y">Old Staff</option>
                        <option value="n">New Staff</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Upload" /></td>
            </tr>
        </tbody>
    </table>

</form>
<?php elseif(@$STEP == "second"): ?>
<form method="post" action="<?=base_url()?>employee/uploadusers/0">
    <input type="hidden" name="is_old" value="<?=@$isOld?>" />
    <input type="hidden" name="filename" value="<?=@$FILENAME?>" />
    <table class="tbl">
        <thead>
            <tr>
                <td>Second Step</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>you need to <?=@$NUMBER?> from step for add all users</td>
            </tr>
            <tr>
                <td><input type="submit" value="Start >" /></td>
            </tr>
        </tbody>
    </table>
</form>
<?php elseif(@$STEP == "last"): ?>
<form method="post" action="<?=base_url()?>employee/uploadusers/<?=@$START?>">
    <input type="hidden" name="is_old" value="<?=@$isOld?>" />
    <input type="hidden" name="filename" value="<?=@$FILENAME?>" />
    <table class="tbl">
        <thead>
            <tr>
                <td colspan="10">Step <?=@$CURRENT?> From <?=@$NUMBER?> Steps</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php $i=1; foreach ($users as $row): ?>
                <td><?=$row['name']?> <img src="<?=base_url()?>style/icon/<?=($row['doing'] == 'y')? "right.gif":"del.png"?>" /></td>
                    <?php if(($i%5) == 0): ?>
                        </tr>
                        <tr>
                    <?php endif; ?>
                <?php $i++; endforeach; ?>
            </tr>
            <tr>
                <td colspan="10"><input type="submit" value="<?=@$button?>" /></td>
            </tr>
        </tbody>
    </table>
</form>
<?php endif; ?>
