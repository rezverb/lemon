var geocoder = new google.maps.Geocoder();

function geocodePosition(pos) {
    geocoder.geocode({
        latLng: pos
    }, function(responses) {
        if (responses && responses.length > 0) {
            updateMarkerAddress(responses[0].formatted_address);
        } else {
            updateMarkerAddress('Cannot determine address at this location.');
        }
    });
}

function updateMarkerStatus(str) {
    document.getElementById('markerStatus').value = str;
}

function updateMarkerPosition(latLng) {


    document.getElementById('longitude').value = latLng.lng();
    document.getElementById('latitude').value = latLng.lat();

   /* document.getElementById('info').innerHTML = [
        latLng.lat(),
        latLng.lng()
    ].join(', ');
    */
}

function updateMarkerAddress(str) {
    document.getElementById('markerStatus').value = str;
}

function initialize(coord) {

    //alert(coord.lat);
    //alert(coord.lng);
    if(typeof  coord.lat == 'undefined' || typeof  coord.lng == 'undefined')
    {


        var latLng = new google.maps.LatLng(42.656188644541274, -75.88540553437497);
    }
    else
    {
        var latLng = new google.maps.LatLng(coord.lat,coord.lng);
    }


    var map = new google.maps.Map(document.getElementById('mapCanvas'), {
        zoom: 17,
        center: latLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var marker = new google.maps.Marker({
        position: latLng,
        title: 'Point A',
        map: map,
        draggable: true
    });

    // Update current position info.
    updateMarkerPosition(latLng);
    geocodePosition(latLng);

    // Add dragging event listeners.
    google.maps.event.addListener(marker, 'dragstart', function() {
        updateMarkerAddress('Dragging...');
    });

    google.maps.event.addListener(marker, 'drag', function() {
        updateMarkerStatus('Dragging...');
        updateMarkerPosition(marker.getPosition());
    });

    google.maps.event.addListener(marker, 'dragend', function() {
        updateMarkerStatus('Drag ended');
        geocodePosition(marker.getPosition());
    });
}

//function close_popup()
//{
//    markup = document.getElementById('info').innerHTML;
//    window.opener.PopUpHandler(markup);
//    window.close();
//}

// Onload handler to fire off the app.
//24.8231897065261,55.6620061126891
google.maps.event.addDomListener(window, 'load', initialize);


$(document).ready(function(){


    var lat;
    var lng;
    $(".processlocation").change(function(){

        alert("ccccc");
        var location ="";
        $(".processlocation").each(function(){
            if($(this).val() != "" && $(this).val() != "Enter city name")
            {
                if(location != "")
                {
                    location = $(this).val()+","+location;
                }
                else
                {
                    location = $(this).val();
                }
            }


        });

        location=location.split(' ').join('+');

        //alert("https://maps.googleapis.com/maps/api/geocode/json?address="+location+"&sensor=false&key=AIzaSyAmpgyciNjzNV0FFLDBjpikpVvWJ_CVc_8");

        $.getJSON("https://maps.googleapis.com/maps/api/geocode/json?address="+location+"&sensor=false&key=AIzaSyAmpgyciNjzNV0FFLDBjpikpVvWJ_CVc_8", function(result){
          // alert(result.results[0].geometry.location.lat)
            if(typeof(result.results[2]) != "undefined")
            {
                var lat =result.results[2].geometry.location.lat;
                var lng =result.results[2].geometry.location.lng;



            }
            else
            {
                var lat =result.results[0].geometry.location.lat;
                var lng =result.results[0].geometry.location.lng;

            }


            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
           
            initialize({'lat':lat,'lng':lng});

        });



    });
});