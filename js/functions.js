$(document).ready(function(){
    
    // For Menu
    $('.navigation li').hover(
            function () {
            $('ul', this).fadeIn();
            },
            function () {
            $('ul', this).fadeOut();
            }
    );
        
    $('#signatureurl').popupWindow({ 
        height:300, 
        width:400, 
        top:50, 
        left:50 
    }); 
    
});

    function deleted(URL,id, texti){
        if(texti == "")
            texti = "Not Found";
        
        if (confirm('Are you sure you want to delete ?'))
        {
            $('#delete').load(URL);
            $('#delete').css( "display", "block" );
            $('#'+id).click(function() {
                //change the background color to red before removing
                $(this).css("background-color","#FF3700");
                $(this).css("color","#FFFFFF");
                $(this).fadeOut(1000, function(){
                    $(this).remove();
                });
            });
            var rowCount = $('#list >tbody >tr').length;
            if(rowCount == 2)
                $('#list tbody').append('<tr><td colspan="5">'+texti+'</td></tr>');

            $('#delete').fadeOut(5000, function(){
                $(this).css("display","none");
                $(this).html("");
            });
        }
    }
    
    function added(URL,id){

        $('#add').load(URL);
        $('#add').css( "display", "block" );
        $('#'+id).click(function() {
            //change the background color to red before removing
            $(this).css("background-color","#FF3700");
            $(this).css("color","#FFFFFF");
            $(this).fadeOut(1000, function(){
                $(this).remove();
            });
        });
        $('#add').fadeOut(5000, function(){
            $(this).css("display","none");
            $(this).html("");
    });

    }

    function deleteTestament(URL,id){
        
        if (confirm('Are you sure you want to delete ?'))
        {
            $('#delete').load(URL);
            $('#delete').css( "display", "block" );
            $('#'+id).click(function() {
                //change the background color to red before removing
                $(this).css("background-color","#FF3700");
                $(this).css("color","#FFFFFF");
                $(this).fadeOut(1000, function(){
                    $(this).remove();
                });
            });
            var rowCount = $('#listR >tbody >tr').length;
            if(rowCount == 2)
                $('#listR tbody').append('<tr id="r_testament0"><td colspan="4">Not Found</td></tr>');

            $('#delete').fadeOut(5000, function(){
                $(this).css("display","none");
                $(this).html("");
            });
        }
    }
    
    function addTestament(URL,id){
        
        var number = $('#number').val();
        var size = $('#size').val();
        $('#add').load(URL+"/"+number+"/"+size);
        $('#add').css( "display", "block" );
        var rowCount = $('#listA >tbody >tr').length;
            if(rowCount == 2)
                $('#listA tbody').append('<tr id="r_testament0"><td colspan="4">Not Found</td></tr>');
            $('#a_testament0').remove();
        $('#'+id).click(function() {
            //change the background color to red before removing
            $(this).css("background-color","#FF3700");
            $(this).css("color","#FFFFFF");
            $(this).fadeOut(1000, function(){
                $(this).remove();
            });
        });
        $('#add').fadeOut(5000, function(){
            $(this).css("display","none");
            $(this).html("");
    });

    }
    
    function StartAction(baseurl){
        
        var group = $('#group').val();
        var action = $('#action').val();
        if(action == "report")
            window.location = baseurl+"attendance/report/"+group;
        else
            window.location = baseurl+"attendance/takeAttendance/"+group;
        
    }

    function attendance(url,id,baseurl){

        $('#add').load(url);
        $('#add').css( "display", "block" );
        url = url.replace("added","delete");
        $('#'+id).click(function() {
            var imgurl = baseurl+"style/icon/right.gif"; 
            $(this).html('<img onclick=\'deleteattendance("'+url+'","'+id+'","'+baseurl+'")\' src="'+imgurl+'" />');
            
        });
        $('#add').fadeOut(5000, function(){
            $(this).css("display","none");
            $(this).html("");
    });

    }
    
    function deleteattendance(url,id,baseurl){

        $('#add').load(url);
        $('#add').css( "display", "block" );
        url = url.replace("delete","added");
        $('#'+id).click(function() {
            var imgurl = baseurl+"style/icon/del.png"; 
            $(this).html('<img onclick=\'attendance("'+url+'","'+id+'","'+baseurl+'")\' src="'+imgurl+'" />');
            
        });
        $('#add').fadeOut(5000, function(){
            $(this).css("display","none");
            $(this).html("");
    });

    }