//Adrian Fehr (ID: 15890772)
//function that is connected to admin.html and is accessed when the 'Show Pickup Requests' button is clicked.
function getPickupRequests() {

    //initialize xhr
    var http = false;
    if (window.XMLHttpRequest) {
        http = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        http = new ActiveXObject("Microsoft.XMLHTTP");
    }

    http.onreadystatechange = function() { //Call a function when the state changes.

        if (http.readyState == 4 && http.status == 200) {
            //return the response to the correct html div tag
            document.getElementById("details").innerHTML = http.responseText;
        }
    }

    //send a simple get request
    http.open("GET", "pickup_data.php?getPickups", true);
    http.send();

}
