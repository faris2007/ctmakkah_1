<!DOCTYPE html>
<html>
<head>
    <title><?=$HEAD['TITLE']?></title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/style.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/menu.css" />
    <script type="text/javascript">
        var Token = '<?=$this->core->token(TRUE)?>';
    	document.write('<script type="text/javascript" src="js"><\/script>');
    </script>
    <!--[if IE 6]>
    <style>
        body {behavior: url("csshover3.htc");}
        #menu li .drop {background:url("img/drop.gif") no-repeat right 8px; 
    </style>
    <![endif]-->
    <meta charset="utf-8" />
	<?=meta($HEAD['META']['META'])?>
    <?=$HEAD['OTHER']?>
</head>

<body>
    <div id="notification">
        <div>
            <img src="<?=base_url()?>style/icon/notification.png">
            <span>Welcom To aaaa</span>
        </div>
    </div>
    <div id="top_bar">
    	<a href="#" id="login_link">Login</a>
      	<span style="float:right;direction:rtl">8 ذو القعدة 1433 هـ	 - 2012/09/24 م</span>
    </div>
	<div id="container">
    	<div id="header"></div>
        <?=$MENU?>
		<div id="main_content">
			<?=$CONTENT?>
            <br />
            <br />
        </div>
        <div id="footer">
        	<span>Copyright &copy; ASFAR</span>
        </div>
    </div>
</body>

</html>