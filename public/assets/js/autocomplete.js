/**
 * Created by Cleve on 28/02/15.
 */


var url = "http://localhost/GIT/lemon/public/manage/getcity?countrycode=";
var country_code = "in";
$("#select-city").click(function(){
    $(this).val("");
    country_code =$("#select-country").val();


});

$( "#select-city" ).autocomplete({
    autoFocus: true,
    minLength: 0,
    position: { my : "right top", at: "right bottom" },
    source: url+country_code
});

