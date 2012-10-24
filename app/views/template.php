<!DOCTYPE html>
<html>
<head>
    <title><?=$HEAD['TITLE']?></title>
    <script type="text/javascript">
        var Token = '<?=$this->core->token(TRUE)?>';
        var base_url = '<?=base_url()?>';
        var js_files = ["jquery","jquery.dataTables","functions","jquery.popupWindow"];
        for (js_x in js_files){document.write('<script type="text/javascript" src="' + base_url + 'js/' + js_files[js_x] + '.js"></' + 'script>');}
	document.write('<link type="text/css" rel="stylesheet" href="' + base_url + 'style/style.css">');
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
            <marquee behavior="scroll" scrollamount="4" style="width:850px" direction="left">
                <span class="scrollingtext" style="color: #FFF;">Notification: <?=$this->core->getNotification()?></span>
            </marquee>
            <?=$this->core->getNotification()?>
        </div>
    </div>
    <div id="top_bar">
    	<a href="#" id="login_link">Login</a>
        <span style="float:right;"><?=date("F j, Y, g:i a")?></span>
    </div>
	<div id="container">
    	<div id="header"></div>
        <div id="main_menu">
            <?=$MENU?>
        </div>
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