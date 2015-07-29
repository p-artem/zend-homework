$(document).ready(function() {
  
    $('tbody a#deleteAdmin').on('click' ,(function(e){
       e.preventDefault();
       var currentStr = $(this).parent().parent();
       
       var href = $(this).attr('href');
       var lastIndex = href.lastIndexOf('/');
       var idNum = href.substring(lastIndex+1); 

       $.post(
        '/admin/delete', 
        { 
            id: idNum, 
            },
            function(data){
                if(data.error !== undefined) {
                    $('#error').html(data.error);
                }
                else if(data == true)
                {   
                   currentStr.fadeOut("slow");
                }
            },
            'json'
    );
    }));

});