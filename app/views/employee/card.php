<html>

<head>
    <title>Card</title>
    <script language="JavaScript" type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js"></script>
    <style>
        * {
            font-family: tahoma;
            font-size: 14px;
        }
        
        #card {
            padding: 15px;
            width: 887px;
            height: 450px;
            border: 1px #000 solid;
        }
        
        #personal_img {
            width: 170px;
            height: 170px;
            margin-top: 30px;
            margin-left: 30px;
        }
        
        #title {
            font-size: 50px;
            position: absolute;
            left: 420px;
            margin-top: 70px;
        }
        
        #name {
            font-size: 30px;
            position: absolute;
            left: 350px;
            margin-top: 150px;            
        }
        
        #job {
            font-size: 25px;
            position: absolute;
            left: 250px;
            margin-top: 260px;                        
        }
    </style>

</head>

<body>
    <div id="card">
        <img src="<?=base_url()?>files/show/card/crccjpg.jpg">
        <img src="<?=base_url()?>files/show/personal_img/1000360378.jpg" id="personal_img">
        <span id="title">CRCC O&M</span>
        <span id="name">Ahmad Saleh Ahmad Alghamdi</span>
        <span id="job">Station Control Room Agent</span>
    </div>
</body>

</html>