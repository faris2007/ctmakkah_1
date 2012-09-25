<!DOCTYPE html>
<html>
<head>
	<title></title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/style.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/menu.css" />
    <script type="text/javascript">
    	document.write('<script type="text/javascript" src="js"><\/script>');
	</script>
    <meta charset="utf-8" />
	<?=meta($HEAD['META']['META'])?>
    <?=$HEAD['OTHER']?>
</head>

<body>
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
            <table id="ff" class="tbl" style="width: 95%">
            	<thead>
                	<tr>
                    	<td>Title 1</td>
                        <td>Title 2</td>
                    </tr>
                </thead>
                <tbody>
                	<tr class="td1">
                    	<td>Content 1</td>
                        <td>Content 2</td>
                    </tr>
                	<tr class="td2">
                    	<td>Content 1</td>
                        <td>Content 2</td>
                    </tr>
                </tbody>
            </table>
            <br />
        </div>
        <div id="footer">
        	<span>Copyright &copy; ASFAR</span>
        </div>
    </div>
</body>

</html>