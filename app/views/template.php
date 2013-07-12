<!DOCTYPE html>
<html>
<head>
    <title><?=$HEAD['TITLE']?></title>
    <script type="text/javascript">
        var Token = '<?=$this->core->token(TRUE)?>';
        var base_url = '<?=base_url()?>';
        var js_files = ["jquery","jquery.dataTables","ajaxfileupload","functions","jquery.popupWindow"];
        for (js_x in js_files){document.write('<script type="text/javascript" src="' + base_url + 'js/' + js_files[js_x] + '.js"></' + 'script>');}
	document.write('<link type="text/css" rel="stylesheet" href="' + base_url + 'style/style.css">');
    </script>
    <?php if($this->uri->segment(1, 0) == "home" || $this->uri->segment(2, 0) == "login"): ?>
        <!-- the CSS for Smooth Div Scroll -->
        <link rel="Stylesheet" type="text/css" href="style/smoothDivScroll.css" />

        <!-- Styles for my specific scrolling content -->
        <style type="text/css">

                /*#makeMeScrollable
                {
                        width:90%;
                        height: 50px;
                        position: relative;
                        z-index:0;
                        text-align:center;
                        left:41px;
                }

                /* Replace the last selector for the type of element you have in
                    your scroller. If you have div's use #makeMeScrollable div.scrollableArea div,
                    if you have links use #makeMeScrollable div.scrollableArea a and so on. */
                /*#makeMeScrollable div.scrollableArea a
                {
                        position: relative;
                        float: left;
                        margin: 0;
                        padding: 0;
                        /* If you don't want the images in the scroller to be selectable, try the following
                            block of code. It's just a nice feature that prevent the images from
                            accidentally becoming selected/inverted when the user interacts with the scroller. */
                        /*-webkit-user-select: none;
                        -khtml-user-select: none;
                        -moz-user-select: none;
                        -o-user-select: none;
                        user-select: none;
                }*/
        </style>
        <link rel="stylesheet" href="style/prettyPhoto.css" type="text/css" media="screen" charset="utf-8" />
        <script src="js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
    <?php endif; ?>
    
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
            <marquee behavior="scroll" scrollamount="4" style="width:850px" direction="right">
                <span class="scrollingtext" style="color: #FFF;">التنبيهات: <?=$this->core->getNotification()?></span>
            </marquee>
            
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
        <?php if (@$NAV): ?>
        <div id="nav">
            <ul>
                <li>&rsaquo;</li>
                <li><a href="<?=base_url()?>">Home</a></li>
                <?php foreach($NAV as $key => $value): ?>
                <li>&rsaquo;</li>
                <li><a href="<?=$key?>"><?=$value?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <?php if($this->uri->segment(1, 0) == "home" || $this->uri->segment(2, 0) == "login"): ?>
            <div id="makeMeScrollable">
                <?php /* for($i=1;$i<=62;$i++): ?>
                    <a rel="prettyPhoto[gallery1]" href="gallery/normal/<?=$i?>.jpg" target="_blank"><img src="gallery/thumb/<?=$i?>.jpg" alt="Asfar Images"/></a>
                <?php endfor; */?>
            </div>

            <!-- jQuery UI Widget and Effects Core (custom download)
                You can make your own at: http://jqueryui.com/download -->
            <script src="js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>

            <!-- Latest version (3.0.6) of jQuery Mouse Wheel by Brandon Aaron
                You will find it here: http://brandonaaron.net/code/mousewheel/demos -->
            <script src="js/jquery.mousewheel.min.js" type="text/javascript"></script>

            <!-- jQuery Kinectic (1.5) used for touch scrolling -->
            <script src="js/jquery.kinetic.js" type="text/javascript"></script>

            <!-- Smooth Div Scroll 1.3 minified-->
            <script src="js/jquery.smoothdivscroll-1.3-min.js" type="text/javascript"></script>

            <!-- If you want to look at the uncompressed version you find it at
                js/jquery.smoothDivScroll-1.3.js -->

            <!-- Plugin initialization -->
            <script type="text/javascript">
                    // Initialize the plugin with no custom options
                    $(document).ready(function () {
                            // None of the options are set
                            $("div#makeMeScrollable").smoothDivScroll({
                                    autoScrollingMode: "onStart"
                            });
                    });
            </script>
        <?php endif; ?>
        <div id="main_content">
			<?=$CONTENT?>
            <br />
            <br />
        </div>
        <div id="footer">
            <span>Development & Design By <a href="http://std-hosting.com">Saudi Technical Design</a></span>
        </div>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function(){
                $("a[rel^='prettyPhoto']").prettyPhoto();
            });
        </script>
    </div>
</body>

</html>