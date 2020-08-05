//Adrian Fehr (ID: 15890772)
//function that is connected to booking.html and is accessed when the booking form is submitted
function validateData() {

    //initialize xhr
    var http = false;
    if (window.XMLHttpRequest) {
        http = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        http = new ActiveXObject("Microsoft.XMLHTTP");
    }

    //get the data from the form
    var cust_name = document.forms["bookingForm"]["cust_name"].value;
    var phone_num = document.forms["bookingForm"]["phone_num"].value;
    var street_num = document.forms["bookingForm"]["street_num"].value;
    var street_name = document.forms["bookingForm"]["street_name"].value;
    var suburb = document.forms["bookingForm"]["suburb"].value;
    var dest_suburb = document.forms["bookingForm"]["dest_suburb"].value;
    var pickup_date = document.forms["bookingForm"]["pickup_date"].value;
    var pickup_time = document.forms["bookingForm"]["pickup_time"].value;

    //add it all to an array
    var validateDetailsArray = [cust_name, phone_num, street_num, street_name, suburb, dest_suburb, pickup_date, pickup_time];

    //Iterate thru the array to check for empty fields.
    for (i = 0; i < validateDetailsArray.length; i++) {
        if (validateDetailsArray[i] == "") {
            //Create an alert if an empty field is detected and do not submit data.
            confirm("ERROR! All fields marked with a * must be filled out.");
            return false;
        }
    }

    //get today's date and set the time to zero for the purposes of comparing only the date, not the time
    var ToDate = new Date();
    ToDate.setHours(0, 0, 0, 0);

    //make the date entered in the form the correct format and make sure the time is also zero
    pickup_date = new Date(pickup_date);
    pickup_date.setHours(0, 0, 0, 0);

    //if the pickup date is earlier than today's date create an alert and do not submit data.
    if (pickup_date < ToDate) {
        confirm("ERROR! Pick-up date cannot be earlier than current date.");
        return false;
    }

    //remove the seconds from the customer's pickup time
    var pickup_hours_mins = pickup_time.split(":");

    //set the pickup date's hours and minutes to the customer's pickup time
    pickup_date.setHours(parseInt(pickup_hours_mins[0], 10), parseInt(pickup_hours_mins[1], 10), 0, 0);

    //if the pickup date's time is earlier than the current time create an alert and do not submit data
    if (pickup_date.getTime() < new Date().getTime()) {

        confirm("ERROR! Pick-up time cannot be earlier than current time.");
        return false;
    }

    //else open the confirmation window by making it visible
    document.getElementById("confirmation").style.visibility = 'visible';

    //make two different URLs, depending whether the unit number has been filled out or not
    if (document.forms["bookingForm"]["unit_num"].value != null) {

        //if it has been filled out, get the unit number data
        var unit_num = document.forms["bookingForm"]["unit_num"].value;

        //create the URL
        var params = "cust_name=" + encodeURIComponent(cust_name) + "&cust_phone=" + encodeURIComponent(phone_num) + "&unit_num=" + encodeURIComponent(unit_num) +
            "&street_num=" + encodeURIComponent(street_num) + "&street_name=" + encodeURIComponent(street_name) + "&origin_suburb=" + encodeURIComponent(suburb) +
            "&dest_suburb=" + encodeURIComponent(dest_suburb) + "&pickup_date_time=" + encodeURIComponent(pickup_date);


    } else {
        //else create a URL without a unit number
        var params = "cust_name=" + encodeURIComponent(cust_name) + "&cust_phone=" + encodeURIComponent(phone_num) +
            "&street_num=" + encodeURIComponent(street_num) + "&street_name=" + encodeURIComponent(street_name) + "&origin_suburb=" + encodeURIComponent(suburb) +
            "&dest_suburb=" + encodeURIComponent(dest_suburb) + "&pickup_date_time=" + encodeURIComponent(pickup_date);
    }

    //open xhr connection with the destination being data.php
    var url = 'data.php';
    http.open('POST', url, true);

    //Send the proper header information along with the request
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    http.onreadystatechange = function() { //Call a function when the state changes.
        if (http.readyState == 4 && http.status == 200) {
            //add the response to the confirmation window
            document.getElementById("confirmation").innerHTML = http.responseText;
        }
    }
    //send the request
    http.send(params);

    http.send(null);
}
