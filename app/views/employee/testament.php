<?php if($STEP == "view"): ?>
    <table class="tbl">
        <thead>
            <tr>
                <td colspan="<?=(@$CONTROL)?5:4?>"><?=$this->lang->line('testament_view')?></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>#</td>
                <td><?=$this->lang->line('testament_view_name')?></td>
                <td><?=$this->lang->line('testament_view_type')?></td>
                <td><?=$this->lang->line('testament_view_price')?></td>
                <?php if(@$CONTROL): ?>
                    <td><?=$this->lang->line('testament_view_control')?></td>
                <?php endif; ?>
            </tr>
            <?php if($query) : ?>
                <?php foreach(@$query as $row): ?>
                    <tr>
                        <td><?=$row->id?></td>
                        <td><?=$row->name?></td>
                        <td><?=$row->type?></td>
                        <td><?=$row->mony?></td>
                        <?php if(@$CONTROL): ?>
                            <td>Control</td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
<?php elseif($STEP == "add"): ?>
    <form method="post">
        <table class="tbl">
            <thead>
                <tr>
                    <td colspan="2"><?=$this->lang->line('testament_add')?></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$this->lang->line('testament_name')?></td>
                    <td><input type="text" name="name" id="name" /></td>
                </tr>
                <tr>
                    <td><?=$this->lang->line('testament_type')?></td>
                    <td><input type="text" name="type" id="type" /></td>
                </tr>
                <tr>
                    <td><?=$this->lang->line('testament_mony')?></td>
                    <td><input type="text" name="mony" id="mony" /></td>
                </tr>
                <?php if(@$ERROR): ?>
                    <tr>
                        <td colspan="2"><?=$this->lang->line('testament_add_error')?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td colspan="2"><input type="submit" value="<?=$this->lang->line('testament_button_add')?>"/></td>
                </tr>
            </tbody>
        </table>
    </form>
<?php elseif($STEP == "edit"): ?>
    <form method="post">
        <input type="hidden" name="ID" value="<?=@$ID?>" />
        <table class="tbl">
            <thead>
                <tr>
                    <td colspan="2"><?=$this->lang->line('testament_edit')?></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$this->lang->line('testament_name')?></td>
                    <td><input type="text" name="name" id="name" value="<?=@$NAME?>" /></td>
                </tr>
                <tr>
                    <td><?=$this->lang->line('testament_type')?></td>
                    <td><input type="text" name="type" id="type" value="<?=@$TYPE?>" /></td>
                </tr>
                <tr>
                    <td><?=$this->lang->line('testament_mony')?></td>
                    <td><input type="text" name="mony" id="mony" value="<?=@$MONY?>" /></td>
                </tr>
                <?php if(@$ERROR): ?>
                    <tr>
                        <td colspan="2"><?=$this->lang->line('testament_add_error')?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td colspan="2"><input type="submit" value="<?=$this->lang->line('testament_button_edit')?>"/></td>
                </tr>
            </tbody>
        </table>
    </form>
<?php elseif($STEP == "success"): ?>
<div>
    <?=$MSG?>
</div>
<?php endif; ?>

