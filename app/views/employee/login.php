<?php if($STEP == "login"): ?>
    <form method ="post">
        <table class ="tbl" style="width: 50%;margin-top: 15px;">
            <thead>
                <tr>
                    <td colspan="2"><?=$this->lang->line('login_text');?></td>
                </tr>      
            </thead>
            <tbody>
                <tr>
                    <td style="width: 30%;"><?=$this->lang->line('login_ID');?></td>
                    <td><input type="text" name="loginID" id="loginID" placeholder="ID ..." value="" maxlength="10" style="width: 70%" /></td>
                </tr>
                <tr>
                    <td><?=$this->lang->line('login_pass');?></td>
                    <td><input type="password" name="password" id="password" placeholder="password" style="width: 70%" /></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="<?=$this->lang->line('login_button');?>" /></td>
                </tr>
                <?php if($ERROR): ?>
                    <tr>
                        <td colspan="2"><?=$this->lang->line('login_error');?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </form>
<?php elseif($STEP=="success"): ?>
    <div class="message">
            <?=@$this->lang->line('login_success');?>
    </div>
<?php elseif($STEP=="logout"): ?>
    <div class="message">
            <?=@$this->lang->line('logout_success');?>
    </div>
<?php endif; ?>
