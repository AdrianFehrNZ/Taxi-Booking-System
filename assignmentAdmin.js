//Adrian Fehr (ID: 15890772)
//function that is connected to admin.html and is accessed when a reference number is assigned.
function assignReference(ref_num) {

    //initialize xhr
    var http = false;
    if (window.XMLHttpRequest) {
        http = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        http = new ActiveXObject("Microsoft.XMLHTTP");
    }
    //make the reference number a string
    ref_num = "reference "+ref_num;

    //Create the URL and add the reference number
    ref_num_uri = "pickup_data.php?assign=" + encodeURIComponent(ref_num);
    http.onreadystatechange = function() { //Call a function when the state changes.

        if (http.readyState == 4 && http.status == 200) {
            //return the response to the correct html div tag
            document.getElementById("assign").innerHTML = http.responseText;
        }
    }
    //send the get request
    http.open("GET", ref_num_uri , true);

    http.send();

}
