Web Dev Assignment 2 - Adrian Fehr (15890772)

File List:

- booking.html
- booking_validation.js
- data.php
- your_taxi.jpg
- chauffeur.jpg

- admin.html
- assignmentAdmin.js
- pickupAdmin.js
- pickup_data.php

- php_styles.css
- settings.php (database connection details)
- Assignment2SQL.sql
- readme.txt

NOTE: This code needs to be run through Apache and MySQL (i.e. in XAMPP)

Brief Instructions:

- To run the system, first open booking.html. From here you can enter details for a booking time for a taxi, and then click the 'Book' button.
- If you leave a field empty (except for the optional unit number) you will be reminded that you need to fill out all the fields.
- If the date is earlier than the current date, you will be prompted to enter another date.
- If the time is earlier than the current time, you will be prompted to enter another time.
- When you make a successful booking, a confirmation pop-up window will open, telling you the details of your booked trip.

- Next, open admin.html. From here you can check if there are any trips that are scheduled for the next two hours by clicking 
  the 'Show Pick-Up Requests' button. These will be displayed in a table.
- You can also enter a reference number in the text field and click the 'Assign' button. If the reference number exists and has not yet been 
  assigned, it will change the referenced trip's status to 'assigned' in the database and display a confirmation message to the user. 

  Note: the reference number entered in the textfield does not necessarily need to be one of the ones displayed by the 'Show Pick-Up Requests' button.
	As long as it is a valid reference and has not yet been assigned, you may change its status.
 
