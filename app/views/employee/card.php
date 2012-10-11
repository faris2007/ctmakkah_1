<html>

<head>
    <title>Card</title>
    <script language="JavaScript" type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js"></script>
    <style>
        * {
            font-family: tahoma;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }
        
        #card {
            color: #000;
            width: 324px;
            height: 207px;
        }
        
        #logo {
            width: 97%;
            height: 55px;
			margin: auto auto auto auto;
			display: block;
        }
        
        #personal_img {
            width: 90px;
            height: 90px;
            margin-top: 25px;
            margin-left: 10px;
			border: 1px #000 solid;
        }
        
        #title {
            font-size: 18px;
            position: absolute;
            left: 170px;
            margin-top: 22px;
        }
        
        #name {
            font-size: 16px;
            position: absolute;
            left: 120px;
            margin-top: 60px;
            width: 180px;
            text-justify: distribute;
            text-align: center;
        }
        
        #job {
            font-size: 16px;
            position: absolute;
            left: 110px;
            margin-top: 90px;
            text-justify: distribute;
            text-align: center;
            width: 200px;
        }
		
		#idn {
            font-size: 12px;
            position: absolute;
            left: 25px;
            margin-top: 120px;
            text-justify: distribute;
            text-align: center;			
		}
    </style>

</head>

<body>
    <?php if ($TYPE == 'main') : ?>
    <div style="color: #F00;text-align: center;"><?=(isset($MSG)) ? $MSG : '' ?></div>
    <form method="post" target="_blank">
        <div style="margin: auto;width: 400px;margin-top: 5px;color: #000;">
            <span>Employee ID : </span>
            <input type="text" name="employee_id" />
            <input type="hidden" name="do" value="print" />
            <input type="submit" value="  Ok  " />
        </div>
    </form>
    <?php elseif ($TYPE == 'print') : ?>
    <div id="card">
        <img id="logo" src="<?=base_url()?>files/card/crccjpg">
        <img id="personal_img" src="<?=base_url()?>files/personal_img/<?=$idn?>">
        <span id="title">CRCC O&M</span>
        <span id="name"><?=$name?></span>
        <span id="job"><?=$job?></span>
        <span id="idn">ID : <?=$idn?></span>
    </div>
    <?php endif; ?>
</body>

</html>