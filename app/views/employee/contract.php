<?php if($STEP == "list"): ?>
    <div class="message" id="contract" style="display: none;"></div>
    <table class="tbl"  style="width:95%">
        <thead>
            <tr>
                <td colspan="2">Search on users if is contract</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>National ID :</td>
                <td><input type="text" id="idn" name="idn" placeholder="ID .." /></td>
            </tr>
            <tr>
                <td colspan="2"><button onclick="Search('<?=base_url()?>employee/contract/0/search','contract');">Search</button></td>
            </tr>
        </tbody>
    </table>
    <br />
    <form method="post">
        <table class="tbl" style="width:95%">
            <thead>
                <tr>
                    <td colspan="2">add Employees as contract</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nationals ID :</td>
                    <td><textarea name="IDNS" style="width:80%"></textarea></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit"  value="Add" /></td>
                </tr>
            </tbody>
        </table>
    </form>

    <table class="tbl" style="width:95%">
        <thead>
            <tr>
                <td colspan="6">List of users was contract</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>#</td>
                <td>National ID</td>
                <td>Name</td>
                <td>Position</td>
                <td>Mobile</td>
                <td>Contract</td>
            </tr>
            <?php if(@$users): ?>
                <?php foreach($users as $row): ?>
                <tr>
                    <td><?=$row->contract_id?></td>
                    <td><?=$row->idn?></td>
                    <td><?=$row->en_name?></td>
                    <td><?=$row->grade?></td>
                    <td><?=$row->mobile?></td>
                    <td><?=$this->core->getNameOfContract($row->isContract)?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <?php if(@$pagination) : ?>
        <div class="message"><?=$pagination?></div>
    <?php endif; ?>
<?php elseif(@$STEP == "contract") : ?>
<div class="message"><a href="<?=base_url()?>employee/contract">Back To Contract</a></div>
<table class="tbl" style="width:70%">
    <thead>
        <tr>
            <td colspan="2">Result for Contract</td>
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

