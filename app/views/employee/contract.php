<?php if($STEP == "list"): ?>
    <div class="message" id="contract" style="display: none;"></div>
    <div class="message"><a href="<?=base_url()?>testament/download/usersContract.csv">Download users who is contracted with them as CSV</a></div>
    <div class="message"><a href="<?=base_url()?>testament/download/usersNoContract.csv">Download users who isn't contracted with them as CSV</a></div>
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
    <br />
    <div class="demo_jui">
        <table class="tbl" id="list" style="width:100%">
            <thead>
                <tr>
                    <th colspan="6">List of users was contract</th>
                </tr>
                <tr>
                    <th>#</th>
                    <th>National ID</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Mobile</th>
                    <th>Contract</th>
                </tr>
            </thead>
            <tbody>
                <?php if(@$users): ?>
                    <?php foreach($users as $row): ?>
                    <tr>
                        <td><?=$row->contract_id?></td>
                        <td><a href="<?=base_url()?>employee/profile/<?=$row->idn?>"><?=$row->idn?></a></td>
                        <td><?=$row->en_name?></td>
                        <td><?=$row->grade?></td>
                        <td><?=$row->mobile?></td>
                        <td><?=$this->core->getNameOfContract($row->isContract)?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
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

