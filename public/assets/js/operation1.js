$(document).ready(function(){


    $("#select-country").change(function(){
       alert($(this).val());
    });

    $("#select-city").click(function(){

        $(this).val("");

    });

    $('#select-city').keyup(function(e){
        if(e.keyCode == 13)
        {
            $(this).trigger("enterKey");
        }
    });


});