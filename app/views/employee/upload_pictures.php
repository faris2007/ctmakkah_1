<?php if($STEP == "upload"): ?>
<form method="post" enctype="multipart/form-data" action="<?=base_url()?>employee/uploadpictures">
    <table class="tbl">
        <thead>
            <tr>
                <td colspan="2">Upload pictures as zip file</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Select zip file (tip:less than 25 MB) :</td>
                <td><input type="file" name="userfile" /></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Upload" /></td>
            </tr>
        </tbody>
    </table>
</form>
<?php elseif($STEP == "extract"): ?>
<form method="post" action="<?=base_url()?>employee/uploadpictures/extract">
    <input type="hidden" name="filename" value="<?=$FILENAME?>" />
    <table class="tbl">
        <thead>
            <tr>
                <td>Extract zip File</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="submit" value="Extract >" /></td>
            </tr>
        </tbody>
    </table>
</form>
<?php elseif($STEP == "success"): ?>
<div class="message">
    <?=@$MSG?>
</div>
<?php endif; ?>
