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
        height:550, 
        width:400, 
        top:50, 
        left:50 
    }); 
    $('#contracturl').popupWindow({ 
        height:550, 
        width:900,
        scrollbars:1,
        top:50, 
        left:50 
    }); 
    if ($('#list').attr('dataajax') !== undefined) {
        $('#list').dataTable({
                    "aLengthMenu": [[50, 100, 250, 500, -1], [50, 100, 250, 500, "All"]],
                    "sPaginationType": "full_numbers",
                    "bJQueryUI": true,
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": "../ajax/"+$('#list').attr('dataajax'),
                    "sServerMethod": "POST",
                    
                    "oLanguage": {
                            "oAria": {
                                "sSortAscending": " - click/return to sort ascending",
                                "sSortDescending": " - click/return to sort descending"
                            },
                            "oPaginate": {
                                "sFirst": "First",
                                "sLast": "Last",
                                "sNext": "Next",
                                "sPrevious": "Previous"
                            },
                            "sLengthMenu": "Display _MENU_ records per page",
                            "sZeroRecords": "Nothing found - sorry",
                            "sInfo": "Showing _START_ to _END_ of _TOTAL_ records",
                            "sInfoEmpty": "Showing 0 to 0 of 0 records",
                            "sInfoFiltered": "(filtered from _MAX_ total records)",
                            "sEmptyTable": "No data available in table",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Please wait - loading...",
                            "sProcessing": "DataTables is currently busy",
                            "sSearch": "Search:"
                    }
            });
    }else{
        $('#list').dataTable({
                    "aLengthMenu": [[50, 100, 250, 500, -1], [50, 100, 250, 500, "All"]],
                    "sPaginationType": "full_numbers",
                    "bJQueryUI": true,
                    "oLanguage": {
                            "oAria": {
                                "sSortAscending": " - click/return to sort ascending",
                                "sSortDescending": " - click/return to sort descending"
                            },
                            "oPaginate": {
                                "sFirst": "First",
                                "sLast": "Last",
                                "sNext": "Next",
                                "sPrevious": "Previous"
                            },
                            "sLengthMenu": "Display _MENU_ records per page",
                            "sZeroRecords": "Nothing found - sorry",
                            "sInfo": "Showing _START_ to _END_ of _TOTAL_ records",
                            "sInfoEmpty": "Showing 0 to 0 of 0 records",
                            "sInfoFiltered": "(filtered from _MAX_ total records)",
                            "sEmptyTable": "No data available in table",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Please wait - loading...",
                            "sProcessing": "DataTables is currently busy",
                            "sSearch": "Search:"
                    }
            });

    }
    
});


    function notificationType(url,id){
        var newurl = "";
        if(id == 0)
            newurl = url+"notification/getTo/"+$("#type").val();
        else
            newurl = url+"notification/getTo/"+$("#type").val()+"/"+id;
        
        $("#dataTo").load(newurl);
    }
    function deleted(URL,id, texti,tableId){
        if(texti == "")
            texti = "Not Found";
        tableId = typeof tableId !== 'undefined' ? tableId : 'list';

        
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
            var rowCount = $('#'+tableId+' >tbody >tr').length;
            if(rowCount == 2)
                $('#'+tableId+' tbody').append('<tr><td colspan="5">'+texti+'</td></tr>');

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
    
    function candidate(URL,id,typel){
        
        $('#candidate').load(URL);
        $('#candidate').css( "display", "block" );
        if(typel === "accept"){
            $('#'+id+'accept').attr("disabled", "disabled");
            $('#'+id+'reject').removeAttr("disabled");
            $('#'+id+'precau').removeAttr("disabled");
        }else if(typel === "reject"){
            $('#'+id+'accept').removeAttr("disabled");
            $('#'+id+'reject').attr("disabled", "disabled");
            $('#'+id+'precau').removeAttr("disabled");
        }else{
            $('#'+id+'accept').removeAttr("disabled");
            $('#'+id+'reject').removeAttr("disabled");
            $('#'+id+'precau').attr("disabled", "disabled");
        }   
        
        $('#candidate').fadeOut(5000, function(){
            $(this).css("display","none");
            $(this).html("");
        });
    }
    
    function Search(URL,id){
        
        var value = $('#idn').val();
        $('#'+id).load(URL+"/"+value);
        $('#'+id).css( "display", "block" );  
        
        $('#'+id).fadeOut(10000, function(){
            $(this).css("display","none");
            $(this).html("");
        });
    }
    
    function addTestament(URL,id){
        
        var number = $('#'+id+'_number').val();
        var size = $('#'+id+'_size').val();
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