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
        
        
});

function deleted(URL,id, texti){
    if(texti == "")
        texti = "Not Found";
    
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
