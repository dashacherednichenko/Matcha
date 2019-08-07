
let latitude;
let longitude;
let country;
let state;
let code;
let city;
let allow;

let tofillinputs = function(callback){
    document.getElementById('gps_latitude').setAttribute('value', latitude);
    document.getElementById('gps_longitude').setAttribute('value', longitude);
    document.getElementById('gps_city').setAttribute('value', city);
    document.getElementById('gps_country').setAttribute('value', country);
    document.getElementById('gps_region').setAttribute('value', state);
    document.getElementById('gps_code').setAttribute('value', code);
    document.getElementById('gps_allowlocation').setAttribute('value', allow);
    // console.log(  document.getElementById('gps_latitude').value,
    //     document.getElementById('gps_longitude').value,
    //     document.getElementById('gps_city').value,
    //     document.getElementById('gps_country').value,
    //     document.getElementById('gps_region').value,
    //     document.getElementById('gps_code').value,
    //     document.getElementById('gps_allowlocation').value
    //     );
    document.getElementById('register_form').submit();
    callback ('ok');
};


let geocode = function(ltt, lng) {
    latitude = ltt;
    longitude = lng;

    let GEOCODING = 'https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyCpslLLMvrUUPGWepKF3r-8g87FCEF2Qek&latlng='+latitude+','+longitude+'&language=en';
    let request = $.ajax({
        url: GEOCODING,
        dataType: 'json',
    });

    request.done(
        function(location) {
            let add = location['plus_code']['compound_code'];
            let value = add.split(",");
            let count = value.length;
            country = value[count - 1];
            if (count == 2) {
                let city_code = value[count - 2].split(" ");
                code = city_code.shift();
                city = city_code.join(' ');
                state = city;
            } else {
                state = value[count - 2];
                let city_code = value[count - 3].split(" ");
                code = city_code.shift();
                city = city_code.join(' ');
            }
            console.log('geocode');
            tofillinputs(function (res) {
                        console.log('tofillinputs', res);
                        // return res;
                    })
        });

    request.fail(function( jqXHR, textStatus ) {
        // Executed in case of error
    });
};


let ip_pos = function () {
    allow = '0';
    let request = $.ajax({
        type: "GET",
        dataType: "json",
        url: 'https://api.ipdata.co?api-key=ef86a8cdcf9c1d049387de03d36272d52fdefccbb4460c0326757254',
    });

    request.done(
        function(data) {
            latitude = data.latitude;
            longitude = data.longitude;
            geocode(data.latitude, data.longitude);
        });

    request.fail(function( jqXHR, textStatus ) {
                // Executed in case of error
    });

};

let gps_pos = () => {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                latitude = position.coords.latitude;
                longitude = position.coords.longitude;
                allow = 1;
            },
            (error) => {
                allow = 0;
                console.log('pppp',  allow);
            });
    }
    else {
    }
};

function fill_input (callback) {
    console.log('var allow', allow);
    if (allow == undefined || allow == 0) {
       ip_pos();
       console.log('block');
    }
    else {
        console.log('allow');
        geocode(latitude, longitude);
    }
};


document.addEventListener('DOMContentLoaded', () => {
    var isFirefox = typeof InstallTrigger !== 'undefined';
    if (isFirefox == false)
    {
        gps_pos();
    }
// console.log('isFirefox', isFirefox);

    let count = 1;
    let pass_inp = document.getElementById('password');
    pass_inp.onblur = function() {
        document.getElementById('requirements').hidden = true;
    };

    pass_inp.onfocus = function() {
        document.getElementById('requirements').hidden = false;
    };


});
document.getElementById('register_button').addEventListener('click', function(event){
    event.preventDefault();

    fill_input(function (res) {});
});
