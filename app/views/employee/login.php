<?php $this->lang->load('login', $LANGUAGE); ?>
<?php if($STEP == "login"): ?>
    <form action="" method ="post">
        <table class ="tbl" width="95%">
            <thead>
                <tr>
                    <td colspan="2"><?=$this->lang->line('login_text');?></td>
                </tr>      
            </thead>
            <tbody>
                <tr>
                    <td><?=$this->lang->line('login_ID');?></td>
                    <td><input type="text" name="loginID" id="loginID" placeholder="ID ..." value="ID ..." maxlength="10" style="width: 70%" /></td>
                </tr>
                <tr>
                    <td><?=$this->lang->line('login_pass');?></td>
                    <td><input type="password" name="password" id="password" placeholder="password" style="width: 70%" /></td>
                </tr>
                <?php if(@$ERROR): ?>
                    <tr>
                        <td colspan="2"><?=$this->lang->line('login_error');?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </form>
<?php elseif($STEP=="success"): ?>
    <div>
            <?=@$this->lang->line('login_success');?>
    </div>
<?php endif; ?>
