<!--file data.php -->
<!--Adrian Fehr (15890772) -->
<!--This file contains methods used by booking.html and booking_validation.js -->
<?php
	// sql info
    require_once('settings.php');

	// The @ operator suppresses the display of any error messages
	// mysqli_connect returns false if connection failed, otherwise a connection value
	$conn = @mysqli_connect($sql_host,
		$sql_user,
		$sql_pass,
		$sql_db
	);

	// Checks if connection is successful
	if (!$conn) {
		echo "<p>Sorry! Database connection failure!</p>";
	}
	else {
		//Upon successful connection

		//Get data from the xhr
		$cust_name = $_POST["cust_name"];
        $cust_phone = $_POST["cust_phone"];
		$unit_num	= $_POST["unit_num"];
		$street_num	= $_POST["street_num"];
		$street_name = $_POST["street_name"];
		$origin_suburb = $_POST["origin_suburb"];
		$dest_suburb = $_POST["dest_suburb"];
		$pickup_date_time = $_POST["pickup_date_time"];

        //remove the non date/time info from the pickup date and time
        $pickup_date_time = substr($pickup_date_time, 0, strpos($pickup_date_time, '('));

        //format in database format
        $pickup_date_time = date("Y-m-d H:i:s", strtotime($pickup_date_time));

        //get current time
        $booking_date_time = date("Y-m-d H:i:s");

		//Check if table exists
		$descTableSQL = "DESC booking_table";
		$result = mysqli_query($conn, $descTableSQL);

		if(!$result)
		{
			echo "<p>Sorry! Database connection failure!</p>";
		}

		else{
			//if table exists then generate reference number
            //first get the maximum current reference number
			$getRefSQL = "SELECT MAX(ref_num) FROM booking_table";
			$result = mysqli_query($conn, $getRefSQL);

            //if there are no rows returned the ref number equals zero
			if(mysqli_num_rows($result)==0)
			{
				$ref_num = 0;
			}

            //else the ref number equals the current max number plus 1
			else{
                while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
                    $ref_num = $row[0] +1;
                }
			}

			//then create sql query that will insert the xhr data, the new ref number, the date/time variables, and a status of 'unassigned'
			$query = "insert into booking_table values ('$ref_num','$cust_name',
            '$cust_phone','$unit_num','$street_num', '$street_name', '$origin_suburb','$dest_suburb',
            '$pickup_date_time','$booking_date_time','unassigned')";

            $result = mysqli_query($conn, $query);

            //create variables for the pickup date and time separately
            $pickup_date = date("d-m-Y", strtotime($pickup_date_time));
            $pickup_time = date("H:i", strtotime($pickup_date_time));

			//If there is no result set returned, there must be an error accessing the DB
        	if(!$result){
				echo "<p>Sorry! Database connection failure!</p>";
			}

            //else return the required data
			else{
				echo "<p style='margin-left: 5px'>Thank you! Your booking reference number is: $ref_num.</p>";
                echo "<p style='margin-left: 5px'>You will be picked up in front of the provided address at $pickup_time on $pickup_date.</p>";
                echo "<br /><a href='booking.html' style='margin-left: 5px'>Make a New Booking</a>";
			}
		}
		// close the database connection
		mysqli_close($conn);
	}
?>
