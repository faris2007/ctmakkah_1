<?php if(@$ADMIN): ?>
    <?php if(@$STEP == "add"): ?>
        <form method="post">
            <table class="tbl" style="width:65%">
                <thead>
                    <tr>
                        <td colspan="2">Add salary to Employee</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>National ID :</td>
                        <td><textarea name="IDNS" style="width:80%"></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit"  value="Add Salary" /></td>
                    </tr>
                </tbody>
            </table>
        </form>
    <?php elseif(@$STEP == "success") : ?>
        <div class="message"><a href="<?=base_url()?>employee/salary/add">Back To Add salary</a></div>
        <table class="tbl" style="width:65%">
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
<?php else: ?>
    <?php if(@$CANTAKESALARY): ?>
    <br />
    <table class="tbl1" style="width:65%">
        <thead>
            <tr>
                <td colspan="2">Detail of Salary</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>The Salary :</td>
                <td><?=@$SALARY?></td>
            </tr>
            <tr>
                <td>Bounce :</td>
                <td><?=@$BOUNCE?></td>
            </tr>
            <tr style="background-color:red;color:white;">
                <td style="color:white;">Penalties :</td>
                <td style="color:white;"><?=(@$PENALTY == 0)? @$PENALTY : "-".@$PENALTY?></td>
            </tr>
            <tr>
                <td>Total :</td>
                <td><?=(@$SALARY+@$BOUNCE)-@$PENALTY?></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">before you come to delivery your salary you want to print this document <a href="<?=base_url()?>employee/getPayment">Download</a></td>
            </tr>
        </tfoot>
    </table>
    <br />
    <table class="tbl" id="penalty" style="width:85%">
        <thead>
            <tr>
                <td colspan="5">List for penalty</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>#</td>
                <td>Type of penalty (length)</td>
                <td>Date</td>
                <td>Time</td>
                <td>Amount of penalty</td>
            </tr>
            <?php if(@$penalties): ?>
                <?php foreach ($penalties as $row):?>
                    <tr id="penalty<?=@$row->id?>">
                        <td><?=@$row->id?></td>
                        <td><?=@$row->name." (".@$row->length.")"?></td>
                        <td><?=@$row->date?></td>
                        <td><?=@$row->time?></td>
                        <td><?=@$row->penaltyAmount?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5">Not Found any type yet</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="message">
        <?=@$MSG?>
    </div>
    <?php endif; ?>
<?php endif; ?>
