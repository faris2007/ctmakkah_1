<ul class="navigation">
    <li><a href="<?=base_url()?>" style="padding:5px 7px 8px 7px;"><img style="vertical-align: middle;" src="<?=base_url()?>style/icon/home.png"></a></li>
    <li><a href="#">Services</a>
        <ul>
            <li><a href="<?=base_url()?>employee/profile">Profile</a></li>
            <li><a href="<?=base_url()?>testament">Testaments</a></li>
            <li><a href="<?=base_url()?>group">Group</a></li>
            <li><a href="<?=base_url()?>job">Job</a></li>
            <li><a href="<?=base_url()?>post">Post</a></li>
        </ul>
		<div class="clear"></div>
    </li>
    <?php if($this->core->checkPermissions("admin","all","all","all")): ?>
        <li><a href="#">Procedures</a>
            <ul>
                <li><a href="<?=base_url()?>testament/addtouser">Delivery Testament</a></li>
            </ul>
        </li>
    <?php endif; ?>
    <?php if($this->users->isLogin()): ?>
        <li><a href="<?=base_url()?>login/logout">Logout</a></li>
    <?php else : ?>
        <li><a href="<?=base_url()?>login/Register">Register</a></li>
    <?php endif; ?>
</ul>
<div class="clear"></div>