<ul class="navigation">
    <li><a href="<?=base_url()?>" style="padding:5px 7px 8px 7px;"><img style="vertical-align: middle;" src="<?=base_url()?>style/icon/home.png"></a></li>
    <li><a href="#">Services</a>
        <ul>
            <?php if($this->users->isLogin()): ?>
                <li><a href="<?=base_url()?>employee/profile">Profile</a></li><?/*
                <li><a href="<?=base_url()?>employee/salary">View Salary</a></li>
                <li><a id="contracturl" href="<?=base_url()?>employee/contract_view">View Contract</a></li>*/?>
                <li><a href="<?=base_url()?>testament">Testaments</a></li>
                <li><a href="<?=base_url()?>work">Table Of Work</a></li>
                <?php if(@$this->core->checkPermissions("group","view")): ?>
                    <li><a href="<?=base_url()?>group">Group</a></li>
                <?php endif; ?>
                <?php if(@$this->core->checkPermissions("job","view")): ?>
                    <li><a href="<?=base_url()?>job">Job</a></li>
                <?php endif; ?>
                <?php if(@$this->core->checkPermissions("penalty","view")): ?>
                    <li><a href="<?=base_url()?>penalty">Penalty</a></li>
                <?php endif; ?>
                <?php if(@$this->core->checkPermissions("attendance","view")): ?>
                    <li><a href="<?=base_url()?>attendance">Attendance</a></li>
                <?php endif; ?>
                <?php if(@$this->core->checkPermissions("job","view")): ?>
                    <li><a href="<?=base_url()?>notification">Notification</a></li>
                <?php endif; ?>
                <li><a href="<?=base_url()?>post">Post</a></li>
            <?php endif; ?>
        </ul>
		<div class="clear"></div>
    </li>
    <?php if($this->users->isLogin() && !$this->users->checkIfUser()): ?>
        <li><a href="#">Procedures</a>
            <ul>
                <li><a href="<?=base_url()?>testament/addtouser">Delivery Testament</a></li>
                <li><a href="<?=base_url()?>attendance/takeattendance">take Attendance</a></li>
                <li><a href="<?=base_url()?>employee/cards">Cards</a></li>
                <li><a href="<?=base_url()?>employee/salary/add">Add Salary</a></li>
            </ul>
        </li>
    <?php endif; ?>
    <?php if(@$this->core->checkPermissions("employee","view")): ?>
        <li><a href="#">Employers</a>
            <ul>
                <li><a href="<?=base_url()?>employee/candidate">Candidate</a></li>
                <li><a href="<?=base_url()?>employee/accepted">Accepted</a></li>
                <li><a href="<?=base_url()?>employee/rejected">Rejected</a></li>
                <li><a href="<?=base_url()?>employee/precaution">Precaution</a></li>
                <li><a href="<?=base_url()?>employee/contract">Contract</a></li>
                <li><a href="<?=base_url()?>employee/users">Users</a></li>
                <li><a href="<?=base_url()?>employee/uploadusers">Upload Users</a></li>
                <li><a href="<?=base_url()?>employee/uploadpictures">Upload Pictures</a></li>
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