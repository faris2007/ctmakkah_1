<html>

<head>
    <title>Signature</title>
    <script language="JavaScript" type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="http://github.com/brinley/jSignature/raw/master/jSignature.js"></script>
    <script language="JavaScript" type="text/javascript" src="http://github.com/brinley/jSignature/raw/master/jSignature.CompressorBase30.js"></script>
    <script type="text/javascript">
        var Token = '<?=$this->core->token(TRUE)?>';
        var base_url = '<?=base_url()?>';
      
        $(document).ready(function() {
                $("#jSignature").jSignature({width:400,height:200,color:'#E13300'});
                $("#signature").attr("src",$('#signature').val());
                $("#clear").click(function() {
                        $("#jSignature").jSignature("clear");
                });
                $("#jSignature").jSignature("setData", "data:<?=$SIGNATURE?>") 
                $('#save').click(function() {
                        $('#signature').val($('#jSignature').jSignature('getData', 'base30'));
                        $('#form_signature').submit();
                });
        });
    </script>
    <style>
        * {
            font-family: tahoma;
            font-size: 14px;
        }
        
        #buttons {
            margin: auto;
            width: 400px;
        }
    </style>

</head>

<body>
    <form method="post" id="form_signature">
    <input type="hidden" name="employee_id" id="employee_id" value="<?=$EMPLOYEE_ID?>" />
    <input type="hidden" name="signature" id="signature" value="<?=$SIGNATURE?>" />
    <div id="buttons">
        <div id="jSignature"></div>
        <input type="button" value="Clear" id="clear" />
        <input type="button" value="Save" id="save" />
    </div>
    </form>
</body>

</html>