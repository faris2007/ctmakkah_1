<?php if($STEP == "view"): ?>
<div id="delete" class="tbl" style="color:white;background-color:red;display:none;width:50%;text-align:center" ></div>
    <table class="tbl" id="list">
        <thead>
            <tr>
                <td colspan="3"><?=$this->lang->line('post_view')?></td>
                <td><a href="<?=base_url()?>post/add"><img src="<?=base_url()?>style/icon/add.png" title="<?=$this->lang->line('icon_add')?>" /></a></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>#</td>
                <td><?=$this->lang->line('post_view_title')?></td>
                <td><?=$this->lang->line('post_view_date')?></td>
                <td><?=$this->lang->line('post_view_from')?></td>
            </tr>
            <?php if($query) : ?>
                <?php foreach(@$query as $row): $user = $this->users->get_info_user("all",$row->from_users_id); ?>
                    <tr id="posts<?=$row->id?>">
                        <td><?=$row->id?></td>
                        <td><?=$row->title?></td>
                        <td><?=$row->date?></td>
                        <td><?=$user['profile']->en_name?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                    <tr>
                        <td colspan="4"><?=$this->lang->line('post_view_nothing')?></td>
                    </tr>
            <?php endif; ?>
        </tbody>
    </table>
<?php elseif($STEP == "add"): ?>
    <form method="post">
        <input type="hidden" name="number" value="1" />
        <table class="tbl">
            <thead>
                <tr>
                    <td colspan="2"><?=$this->lang->line('post_add')?></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$this->lang->line('post_title')?></td>
                    <td><input type="text" name="title" id="title" /></td>
                </tr>
                <tr>
                    <td><?=$this->lang->line('post_note')?></td>
                    <td>
                        <textarea id="note" name="note" style="width: 80%">

			</textarea>
                    </td>
                </tr>
                <?php if(@$ERROR): ?>
                    <tr>
                        <td colspan="2"><?=$this->lang->line('post_add_error')?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td colspan="2"><input type="submit" value="<?=$this->lang->line('post_button_add')?>"/></td>
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
                    <td colspan="2"><?=$this->lang->line('post_edit')?></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$this->lang->line('post_title')?></td>
                    <td><input type="text" name="title" id="title" value="<?=@$TITLEM?>" /></td>
                </tr>
                <tr>
                    <td><?=$this->lang->line('post_note')?></td>
                    <td>
                        <textarea id="note" name="note" style="width: 80%">
                            <?=@$NOTEM?>
			</textarea>
                    </td>
                </tr>
                <?php if(@$ERROR): ?>
                    <tr>
                        <td colspan="2"><?=$this->lang->line('post_add_error')?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td colspan="2"><input type="submit" value="<?=$this->lang->line('post_button_edit')?>"/></td>
                </tr>
            </tbody>
        </table>
    </form>
<?php elseif($STEP == "success"): ?>
<div>
    <?=$MSG?>
</div>
<?php elseif($STEP == "show"): ?>
<table class="tbl">
    <tbody>
        <tr>
            <td><?=$this->lang->line('post_view_title')?></td>
            <td><?=@$TITLEM?></td>
        </tr>
        <tr>
            <td><?=$this->lang->line('post_view_from')?></td>
            <td><?=@$FORM?></td>
        </tr>
        <tr>
            <td><?=$this->lang->line('post_view_date')?></td>
            <td><?=@$DATE?></td>
        </tr>
        <tr>
            <td colspan="2"><?=@$NOTEM?></td>
        </tr>
    </tbody>
</table>
<?php if(@$REPLAY): ?>
    <?php foreach($REPLAY as $row): $user = $this->users->get_info_user("all",$row->from_users_id); ?>
        <br />
        <table class="tbl">
            <tbody>
                <tr>
                    <td><?=$this->lang->line('post_view_title')?></td>
                    <td><?=@$row->title?></td>
                </tr>
                <tr>
                    <td><?=$this->lang->line('post_view_from')?></td>
                    <td><?=@$user['profile']->en_name?></td>
                </tr>
                <tr>
                    <td><?=$this->lang->line('post_view_date')?></td>
                    <td><?=@$row->date?></td>
                </tr>
                <tr>
                    <td colspan="2"><?=@$row->notemessage?></td>
                </tr>
            </tbody>
        </table>
    <?php endforeach; ?>
<?php endif; ?>
<br />
<form method="post">
    <input type="hidden" name="number" value="<?=(!$REPLAY)? 2 : 2+count($REPLAY)?>" />
    <table class="tbl">
        <thead>
            <tr>
                <td colspan="2"><?=$this->lang->line('post_add')?></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?=$this->lang->line('post_title')?></td>
                <td><input type="text" name="title" id="title" /></td>
            </tr>
            <tr>
                <td><?=$this->lang->line('post_note')?></td>
                <td>
                    <textarea id="note" name="note" style="width: 80%">

                    </textarea>
                </td>
            </tr>
            <?php if(@$ERROR): ?>
                <tr>
                    <td colspan="2"><?=$this->lang->line('post_add_error')?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td colspan="2"><input type="submit" value="<?=$this->lang->line('post_button_add')?>"/></td>
            </tr>
        </tbody>
    </table>
</form>
<?php endif; ?>

