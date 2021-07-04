var ret;

function getAddress(latitude, longitude, description, map, coordinates, popup) {
    var api_key = 'b3ca83c28fbb4a97973fff6832defb24';
    var api_url = 'https://api.opencagedata.com/geocode/v1/json'

    var request_url = api_url +
        '?' +
        'key=' + api_key +
        '&q=' + encodeURIComponent(latitude + ',' + longitude) +
        '&pretty=1' +
        '&no_annotations=1';

    var request = new XMLHttpRequest();
    request.open('GET', request_url, true);

    request.onload = function () {

        if (request.status === 200) {
            // Success!
            var data = JSON.parse(request.responseText);

            console.log("Success, " + data.results[0].formatted);

            popup.setLngLat(coordinates).setHTML(description + "<br><b>Address: </b>" + data.results[0].formatted).addTo(map);

        } else {
            console.log("server error");
            ret = "ERROR";
        }

        return ret;
    };

    request.onerror = function () {
        console.log("unable to connect to server");
        ret = "ERROR";

        return ret;
    };

    request.send();
}