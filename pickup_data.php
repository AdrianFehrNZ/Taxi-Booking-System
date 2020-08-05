<!--file pickup_data.php -->
<!--Adrian Fehr (15890772) -->
<!--Contains methods that are used by admin.html, assignmentAdmin.js, and pickupAdmin.js-->

<?php
// sql info
require_once('settings.php');

// The @ operator suppresses the display of any error messages
// mysqli_connect returns false if connection failed, otherwise a connection value
$conn = @mysqli_connect($sql_host, $sql_user, $sql_pass, $sql_db);

// Checks if connection is successful
if (!$conn) {
    echo "<p>Sorry! Database connection failure!</p>";
} else {
    //Upon successful connection

    //Get data from the xhr
    $get_pickups  = $_REQUEST["getPickups"];
    $get_assigned = $_REQUEST["assign"];
    $get_assigned = filter_var($get_assigned, FILTER_SANITIZE_NUMBER_INT);

    //Check if table exists

    $descTableSQL = "DESC booking_table";
    $result       = mysqli_query($conn, $descTableSQL);

    //table doesn't exist
    if (!$result) {
        echo "<p>Sorry! Database connection failure!</p>";
    }
    //table exists
    else {
        //if the get pickups variable has been initialized by the xhr
        if ($get_pickups === "") {

            //get current date and time and current date and time plus 2 hours
            $current_date_time = date("Y-m-d H:i:s");
            $max_date_time     = date("Y-m-d H:i:s", strtotime('+2 hours', strtotime($current_date_time)));

            //make them strings for the purposes of accurate comparison
            $current_date_time  = strtotime($current_date_time);
            $max_date_time      = strtotime($max_date_time);

            //get all the records in the table
            $getAllRecordsQuery = "SELECT * FROM booking_table";
            $result             = mysqli_query($conn, $getAllRecordsQuery);

            //If there is no result set returned, there must be an error accessing the DB
            if (!$result) {
                echo "<p>Sorry! Database connection failure!</p>";
            }

            else {
                // if there is a database connection, then build the table
                echo "<table style='width:100%'>";
                echo "<tr><th>Ref Num</th>
                            <th>Customer Name</th>
                            <th>Phone</th>
                            <th>Pickup Suburb</th>
                            <th>Destination Suburb</th>
                            <th>Pickup Date/Time</th></tr>";

                //check each result
                foreach ($result as $res) {
                    //get pickup date and time for each row and make it a string for the purposes of comparison
                    $dbtime = $res['pickup_date_time'];
                    $dbtime = strtotime($dbtime);

                    //if the status is unassigned
                    if ($res['assignment_status'] == 'unassigned') {

                        //and the row's time is within two hours from now
                        if ($dbtime >= $current_date_time) {
                            if ($dbtime <= $max_date_time) {

                                //format the time
                                $dbtime = date("H:i d-m-Y", $dbtime);
                                //add required data to the table
                                echo "<tr><td>$res[ref_num]</td>
                                        <td>$res[cust_name]</td>
                                        <td>$res[cust_phone]</td>
                                        <td>$res[origin_suburb]</td>
                                        <td>$res[dest_suburb]</td>
                                        <td>$dbtime</td></tr>";
                            }
                        }
                    }
                }
                //close table tag
                echo "</table>";
            }
            mysqli_free_result($result);
        }

        //if the $get_assigned variable has been intialized by the xhr
        elseif (!empty($get_assigned)) {

            //check for an unassigned row with that reference number
            $checkReferenceNumExistSQL = "SELECT * FROM booking_table WHERE ref_num = '$get_assigned' AND assignment_status = 'unassigned'";
            $result                    = mysqli_query($conn, $checkReferenceNumExistSQL);
            //there should be at least one result...
            $num_rows                  = mysqli_num_rows($result);

            // if there is no result
            if (!result) {
                echo "<p>Sorry! Database connection failure!</p>";
            }

            //if the query is successful but there are no rows returned
            elseif ($num_rows == 0) {
                echo "<p>Sorry, there is no unassigned trip with that reference number.</p>";
            }

            //else change the row's status to 'assigned'
            else {
                $assignReferenceNumber = "UPDATE booking_table SET assignment_status = 'assigned' WHERE ref_num = '$get_assigned'";
                $result                = mysqli_query($conn, $assignReferenceNumber);

                //If there is no result set returned, there must be an error accessing the DB
                if (!$result) {
                    echo "<p>Sorry! Database connection failure!</p>";
                }
                //the assignment has been successful, return the required data.
                else {
                    echo "<p>The booking request <$get_assigned> has been properly assigned.</p>";

                }
                mysqli_free_result($result);
            }
        }
    }

    // close the database connection
    mysqli_close($conn);

}
?>
