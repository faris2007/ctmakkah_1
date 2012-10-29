<?php if($STEP == "view"): ?>
<div id="delete" class="tbl" style="color:white;background-color:red;display:none;text-align:center" ></div>
<div class="demo_jui">
<table class="tbl" id="list" style="width: 100%;">
        <thead>
            <tr>
                <td colspan="4"><?=$this->lang->line('testament_view')?></td>
                <?php if(@$CONTROL): ?>
                    <td><a href="<?=base_url()?>testament/add"><img src="<?=base_url()?>style/icon/add.png" title="<?=$this->lang->line('icon_add')?>" /></a></td>
                <?php endif; ?>
            </tr>
            <tr>
                <th>#</th>
                <th><?=$this->lang->line('testament_view_name')?></th>
                <th><?=$this->lang->line('testament_view_type')?></th>
                <th><?=$this->lang->line('testament_view_price')?></th>
                <?php if(@$CONTROL): ?>
                    <th><?=$this->lang->line('testament_view_control')?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tfoot>
            
        </tfoot>
        <tbody>
            <?php if($query) : ?>
                <?php foreach(@$query as $row): ?>
                    <tr id="testments<?=$row->id?>">
                        <td><?=$row->id?></td>
                        <td><?=$row->name?></td>
                        <td><?=$row->type?></td>
                        <td><?=$row->mony?></td>
                        <?php if(@$CONTROL): ?>
                        <td>
                            <a href="<?=base_url()?>testament/edit/<?=$row->id?>"><img src="<?=base_url()?>style/icon/edit.png" title="<?=$this->lang->line('icon_edit')?>" /></a>
                            <a onclick="deleted('<?=base_url()?>testament/delete/<?=$row->id?>','testments<?=$row->id?>','<?=$this->lang->line("testament_view_nothing")?>')" ><img src="<?=base_url()?>style/icon/del.png" title="<?=$this->lang->line('icon_del')?>" /></a>
                        </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                    <tr>
                        <td colspan="<?=(@$CONTROL)?5:4?>"><?=$this->lang->line('testament_view_nothing')?></td>
                    </tr>
            <?php endif; ?>
        </tbody>
</table></div>
<?php elseif($STEP == "adduser"): ?>
    <table class="tbl" style="width:80%">
        <thead>
            <tr>
                <td colspan="2">Data Of user</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>User ID</td>
                <td><?=@$ID?></td>
           </tr>
           <tr>
                <td>National ID</td>
                <td><?=@$IDN?></td>
           </tr>
           <tr>
                <td>Name</td>
                <td><?=@$EN_NAME?></td>
           </tr>
           <?php if(@$SIGNATURE): ?>
                <tr>
                    <td>Signature</td>
                    <td><a id="signatureurl" href="<?=base_url()?>employee/signatures/<?=@$ID?>">Please Add Signature</a></td>
                </tr>
           <?php endif; ?>
        </tbody>
    </table>
    <div class="message" id="add" style="display:none"></div>
    <table class="tbl" id="listA" style="width:80%">
        <thead>
            <tr>
                <td colspan="4">add Testament to <?=@$EN_NAME?></td>
            </tr>
        </thead>
        <tbody>
        <tr>
            <td><?=$this->lang->line('testament_view_name')?></td>
            <td><?=$this->lang->line('testament_view_type')?></td>
            <td><?=$this->lang->line('testament_view_price')?></td>
            <td>Size</td>
            <td>Number</td>
            <td>Add</td>
        </tr>
        <?php if($queryA) : ?>
            <?php foreach(@$queryA as $row): ?>
                <tr id="a_testments<?=$row->id?>">
                    <td><?=$row->name?></td>
                    <td><?=$row->type?></td>
                    <td><?=$row->mony?></td>
                    <td>
                        <select name="size" id="a_testments<?=$row->id?>_size">
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                            <option value="XXXL">XXXL</option>
                        </select>
                    </td>
                    <td>
                        <select name="number" id="a_testments<?=$row->id?>_number">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </td>
                    <td><button onclick="addTestament('<?=base_url()?>testament/added/<?=$row->id?>/<?=@$ID?>','a_testments<?=$row->id?>')">ADD</button></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
                <tr id="a_testments0">
                    <td colspan="4"><?=$this->lang->line('testament_view_nothing')?></td>
                </tr>
        <?php endif; ?>
    </tbody>
    </table>
    <div class="message" id="delete" style="display:none"></div>
    <table class="tbl" id="listR" style="width:80%">
        <thead>
            <tr>
                <td colspan="4">Remove testament from <?=@$EN_NAME?></td>
            </tr>
        </thead>
        <tbody>
        <tr>
            <td><?=$this->lang->line('testament_view_name')?></td>
            <td><?=$this->lang->line('testament_view_type')?></td>
            <td><?=$this->lang->line('testament_view_price')?></td>
            <td>Size</td>
            <td>Number</td>
            <td>Remove</td>
        </tr>
        <?php if($queryR) : ?>
            <?php foreach(@$queryR as $rowR): ?>
                <tr id="r_testments<?=$rowR->id?>">
                    <td><?=$rowR->name?></td>
                    <td><?=$rowR->type?></td>
                    <td><?=$rowR->mony?></td>
                    <td><?=$rowR->size?></td>
                    <td><?=$rowR->number?></td>
                    <td><button onclick="deleteTestament('<?=base_url()?>testament/delete/<?=$rowR->id?>/users/<?=$ID?>','r_testments<?=$rowR->id?>')">Remove</button></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
                <tr id="r_testments0">
                    <td colspan="4"><?=$this->lang->line('testament_view_nothing')?></td>
                </tr>
        <?php endif; ?>
    </tbody>
    </table>
<?php elseif($STEP == "add"): ?>
    <form method="post">
        <table class="tbl" style="width:80%">
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
<?php elseif($STEP == "show"): ?>
    <div class="message"><a href="<?=base_url()?>testament/download/users_has_not_testament.csv">Download users has not Testament as CSV</a></div>
    <div class="message"><a href="<?=base_url()?>testament/download/users_has_testament.csv">Download users has Testament as CSV</a></div>
    <form method="post">
    <table class="tbl" style="width:95%">
        <thead>
            <tr>
                <td colspan="2">add testament to group</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Nationals ID :</td>
                <td><textarea name="IDNS" style="width:80%"></textarea></td>
            </tr>
            <tr>
                <td>Select Action :</td>
                <td>
                    <select name="action">
                        <option value="add">Add</option>
                        <option value="del">Delete</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Select Testament :</td>
                <td>
                    <select name="testaments">
                        <option selected="selected" value="0">None</option>
                        <?php if(@$testaments): ?>
                            <?php foreach(@$testaments as $row): ?>
                                <option value="<?=$row->id?>"><?=$row->name?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>size :</td>
                <td>
                    <select name="size">
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                            <option value="XXXL">XXXL</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Number :</td>
                <td>
                        <select name="number" id="a_testments<?=$row->id?>_number">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="add"  value="Add" /></td>
            </tr>
        </tbody>
    </table>
</form>
<br />
    
    <table class="tbl">
        <thead>
            <tr>
                <td colspan="2">Delivery of Testament for user</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>ID National :</td>
                <td><input type="text" name="IDN" id="IDN" placeholder="ID .." /></td>
            </tr>
            <tr>
                <td colspan="2"><button onclick="window.location = '<?=base_url()?>testament/addtouser/'+$('#IDN').val();">Search</button></td>
            </tr>
        </tbody>
    </table>
<?php elseif($STEP == "edit"): ?>
    <form method="post">
        <input type="hidden" name="ID" value="<?=@$ID?>" />
        <table class="tbl" style="width:80%">
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
<div class="message">
    <?=$MSG?>
</div>
<?php elseif(@$STEP == "addtousers") : ?>
<div class="message"><a href="<?=base_url()?>testament/addtouser">Back To Accepted list</a></div>
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

