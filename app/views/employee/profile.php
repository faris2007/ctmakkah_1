<?php if($STEP =="view"): ?>

<form method="post" action="<?=base_url()?>employee/profile/<?=@$ID?>">
    <table id="profile" class="tbl" style="width: 85%">
        <thead>
            <tr>
                <td colspan="2"><?=@$this->lang->line('profile_show');?></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?=@$this->lang->line('register_name_arabic');?></td>
                <td><input type="text" name="arName" id="arName" placeholder="Name"<?=(@!$ADMIN)?' disabled="disabled"':'' ?> value="<?=@$profile->ar_name?>" style="width: 70%" /></td>
            </tr>
            <tr>
                <td><?=@$this->lang->line('register_name_english');?></td>
                <td><input type="text" name="enName" id="enName" placeholder="Name"<?=(@!$ADMIN)?' disabled="disabled"':'' ?> value="<?=@$profile->en_name?>" style="width: 70%" /></td>
            </tr>
            <tr>
                <td><?=@$this->lang->line('login_ID');?></td>
                <td><input type="text" name="national_id" id="national_id" placeholder="National ID"<?=(@!$ADMIN)?' disabled="disabled"':'' ?> value="<?=@$profile->idn?>" maxlength="10" style="width: 70%" /></td>
            </tr>
            <tr>
                <td><?=@$this->lang->line('register_email');?></td>
                <td><input type="text" name="email" id="email" placeholder="Email"<?=(@!$ADMIN)?' disabled="disabled"':'' ?> value="<?=@$profile->email?>" style="width: 70%" /></td>
            </tr>
            <tr>
                <td><?=@$this->lang->line('register_mobile');?></td>
                <td><input type="text" name="mobile" id="mobile" placeholder="Mobile"<?=(@!$ADMIN)?' disabled="disabled"':'' ?> value="<?=@$profile->mobile?>" style="width: 70%" /></td>
            </tr>
            <tr>
                <td><?=@$this->lang->line('register_gender');?></td>
                <td>
                    <select name="gender" id="gender" style="width: 70%">
                        <option>Select Gender</option>
                        <option<?=(@$profile->gender == $this->lang->line('register_gender_male'))? " selected=\"true\"":""?> value="<?=@$this->lang->line('register_gender_male');?>"><?=@$this->lang->line('register_gender_male');?></option>
                        <option<?=(@$profile->gender == $this->lang->line('register_gender_female'))? " selected=\"true\"":""?> value="<?=@$this->lang->line('register_gender_female');?>"><?=@$this->lang->line('register_gender_female');?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?=@$this->lang->line('register_nationality')?></td>
                <td>
                    <select name="nationality" id="nationality" style="width: 70%">
                        <option>Select Nationality</option>
                        <option<?=(@$profile->nationality == 1)? " selected=\"true\"":""?> value="1">Saudi</option>
                        <option<?=(@$profile->nationality != 1)? " selected=\"true\"":""?> value="2">Non Saudi</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Blood Type : </td>
                <td>
                    <select name="blood">
                        <option<?=(@$profile->blood == 'A+')? " selected=\"true\"":""?> value="A+">A+</option>
                        <option<?=(@$profile->blood == 'A-')? " selected=\"true\"":""?> value="A-">A-</option>
                        <option<?=(@$profile->blood == 'B+')? " selected=\"true\"":""?> value="B+">B+</option>
                        <option<?=(@$profile->blood == 'B-')? " selected=\"true\"":""?> value="B-">B-</option>
                        <option<?=(@$profile->blood == 'AB+')? " selected=\"true\"":""?> value="AB+">AB+</option>
                        <option<?=(@$profile->blood == 'AB-')? " selected=\"true\"":""?> value="AB-">AB-</option>
                        <option<?=(@$profile->blood == 'O+')? " selected=\"true\"":""?> value="O+">O+</option>
                        <option<?=(@$profile->blood == 'O-')? " selected=\"true\"":""?> value="O-">O-</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Bank Name:</td>
                <td><input type="text" name="bankName" required value="<?=@$profile->bankName?>" /> </td>
            </tr>
            <tr>
                <td>your Name In Bank Card :</td>
                <td><input type="text" name="cardName" required value="<?=@$profile->cardName?>" /></td>
            </tr>
            <tr>
                <td>Iban : </td>
                <td><input type="text" name="iban" required value="<?=@$profile->iban?>" /></td>
            </tr>
            <?php if(@$ADMIN): ?>
                <tr>
                    <td>Group</td>
                    <td>
                        <select name="group" id="group" style="width: 70%">
                            <option value="0">Select Group</option>
                            <?php if(@$group): ?>
                                <?php foreach ($group as $value): ?>
                                    <option<?=(@$profile->group_id == $value->id)? " selected=\"selected\"":""?> value="<?=$value->id?>"><?=$value->name?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Job Name</td>
                    <td>
                        <select name="job" id="job" style="width: 70%">
                            <option value="0">Select job</option>
                            <?php if(@$jobs): ?>
                                <?php foreach ($jobs as $value): ?>
                                    <option<?=(@$profile->jobs_id == $value->id)? " selected=\"selected\"":""?> value="<?=$value->id?>"><?=$value->name?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </td>
                </tr>
            <?php endif; ?>
            <?php if(@$ERROR): ?>
                <tr>
                    <td colspan="2"><?=$this->lang->line('login_error');?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td colspan="2"><input type="submit" class="clean-gray" value="<?=@$this->lang->line('profile_button');?>" /></td>
            </tr>
        </tbody>
    </table>
</form>
<?php /*<div class="message">Download Certificate
<br />
you can't download this document more than 1 time. 
</div>
<table class="tbl">
    <thead>
        <tr>
            <td colspan="2">Certificates for <?=@$profile->en_name?></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>‫‪Certificate of Practical Experience‬‬:</td>
            <td><a href="<?=base_url()?>employee/getCertificate">Download</a></td>
        </tr>
    </tbody>
</table>
 * 
 */?>
<?php if(@$ADMIN): ?>
    <div class="message">Attachments:</div>
    <table class="tbl" style="width: 85%">
        <thead>
            <tr>
                <td>Type Of Attachments</td>
                <td>View</td>
            </tr>
        </thead>
        <tbody>
            <?php if($attachments): ?>
                <?php foreach ($attachments as $value): ?>
                    <tr>
                        <td><?=$value->name?></td>
                        <td><a href="<?=$value->file_url?>"><img src="<?=base_url()?>style/icon/show.png" /></a></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
<?php endif; ?>
<div class="message">Change Password</div>
<form action="<?=base_url()?>employee/change_password/<?=@$ID?>" method="post">
    <input type="hidden" name="token" value="<?=$this->core->token(TRUE)?>" />
    <table class="tbl">
        <thead>
            <tr>
                <td colspan="2">Change password for <?=@$profile->en_name?></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Old Password</td>
                <td><input type="password" name="oldpass" placeholder="old password" /></td>
            </tr>
            <tr>
                <td>New Password</td>
                <td><input type="password" name="newpass" placeholder="new password" /></td>
            </tr>
            <tr>
                <td>Retype new Password</td>
                <td><input type="password" name="renewpass" placeholder="retype new password" /></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Change" /></td>
            </tr>

        </tbody>
    </table>
</form>

<?php /* $folder = 'store/personal_img/'; if(@$ADMIN):?>
    <div class="message">
    <?php if((file_exists($folder.@$profile->idn.".jpg") || file_exists($folder.@$profile->idn.".jpeg") || file_exists($folder.@$profile->idn.".png")
                   || file_exists($folder.@$profile->idn." .png") || file_exists($folder.@$profile->idn." .jpg" ) || file_exists($folder.@$profile->idn.".PNG") || file_exists($folder.@$profile->idn.".JPG"))): ?>
        <img id="personal_img" src="<?=base_url()?>files/personal_img/<?=@$profile->idn?>" /><br />
    <?php endif; ?>    
    Upload Personal Picture</div>
    <form action="<?=base_url()?>employee/uploadPicture/<?=@$profile->idn?>" method="post" enctype="multipart/form-data">
        <table class="tbl" style="width:85%">
            <thead>
                <tr>
                    <td colspan="2">Upload Personal Picture for <?=@$profile->en_name?></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Select Picture</td>
                    <td><input type="file" name="userfile" /></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="Upload" /></td>
                </tr>
            </tbody>
        </table>
    </form>
<?php endif;*/?>
<?php elseif (@$STEP == "success") : ?>
    <div class="message">
        <?=@$MSG?>
        <script type="text/javascript">
            redirect('profile');
        </script>
    </div>
<?php endif; ?>

