<?php if($STEP == "view"): ?>
<div id="delete" class="tbl" style="color:white;background-color:red;display:none;width:50%;text-align:center" ></div>
<div class="demo_jui">
<table class="tbl" id="list" style="width:100%">
        <thead>
            <tr>
                <td colspan="4"><?=$this->lang->line('job_view')?></td>
                <?php if(@$CONTROL): ?>
                    <td><a href="<?=base_url()?>job/add"><img src="<?=base_url()?>style/icon/add.png" title="<?=$this->lang->line('icon_add')?>" /></a></td>
                <?php endif; ?>
            </tr>
            <tr>
                <th>#</th>
                <th><?=$this->lang->line('job_view_name')?></th>
                <th><?=$this->lang->line('job_view_date')?></th>
                <th><?=$this->lang->line('job_view_price')?></th>
                <?php if(@$CONTROL): ?>
                    <th><?=$this->lang->line('job_view_control')?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if($query) : ?>
                <?php foreach(@$query as $row): ?>
                    <tr id="jobs<?=$row->id?>">
                        <td><?=$row->id?></td>
                        <td><?=$row->name?></td>
                        <td><?=$row->date?></td>
                        <td><?=$row->mony?></td>
                        <?php if(@$CONTROL): ?>
                        <td>
                            <a href="<?=base_url()?>job/edit/<?=$row->id?>"><img src="<?=base_url()?>style/icon/edit.png" title="<?=$this->lang->line('icon_edit')?>" /></a>
                            <a onclick="deleted('<?=base_url()?>job/delete/<?=$row->id?>','jobs<?=$row->id?>','<?=$this->lang->line("job_view_nothing")?>')" ><img src="<?=base_url()?>style/icon/del.png" title="<?=$this->lang->line('icon_del')?>" /></a>
                        </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
</table></div>
<?php elseif($STEP == "add"): ?>
    <form method="post">
        <table class="tbl" style="width:80%">
            <thead>
                <tr>
                    <td colspan="2"><?=$this->lang->line('job_add')?></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$this->lang->line('job_name')?></td>
                    <td><input type="text" name="name" id="name" /></td>
                </tr>
                <tr>
                    <td><?=$this->lang->line('job_date')?></td>
                    <td><input type="text" name="date" id="date" maxlength="10" /></td>
                </tr>
                <tr>
                    <td><?=$this->lang->line('job_mony')?></td>
                    <td><input type="text" name="mony" id="mony" /></td>
                </tr>
                <?php if(@$ERROR): ?>
                    <tr>
                        <td colspan="2"><?=$this->lang->line('job_add_error')?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td colspan="2"><input type="submit" value="<?=$this->lang->line('job_button_add')?>"/></td>
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
                    <td colspan="2"><?=$this->lang->line('job_edit')?></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$this->lang->line('job_name')?></td>
                    <td><input type="text" name="name" id="name" value="<?=@$NAME?>" /></td>
                </tr>
                <tr>
                    <td><?=$this->lang->line('job_date')?></td>
                    <td><input type="text" name="date" id="date" value="<?=@$DATE?>" maxlength="10" /></td>
                </tr>
                <tr>
                    <td><?=$this->lang->line('job_mony')?></td>
                    <td><input type="text" name="mony" id="mony" value="<?=@$MONY?>" /></td>
                </tr>
                <?php if(@$ERROR): ?>
                    <tr>
                        <td colspan="2"><?=$this->lang->line('job_add_error')?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td colspan="2"><input type="submit" value="<?=$this->lang->line('job_button_edit')?>"/></td>
                </tr>
            </tbody>
        </table>
    </form>
<?php elseif($STEP == "success"): ?>
<div class="message">
    <?=$MSG?>
</div>
<?php endif; ?>

