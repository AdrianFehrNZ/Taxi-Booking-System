//Adrian Fehr (15890772)
//SQL file used for creating, modifying, and querying the DB for Web Dev Assignment 2 

SHOW DATABASES;
USE jpx8596;

CREATE table booking_table (
ref_num INT PRIMARY KEY,
cust_name VARCHAR(20) NOT NULL,
cust_phone VARCHAR(20) NOT NULL,
unit_num VARCHAR(5),
street_num VARCHAR(10) NOT NULL,
street_name VARCHAR(20) NOT NULL,
origin_suburb VARCHAR(20) NOT NULL,
dest_suburb VARCHAR(20) NOT NULL,
pickup_date_time DATETIME NOT NULL,
booking_date_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
assignment_status VARCHAR(20) DEFAULT 'unassigned'
);

ALTER TABLE booking_table
MODIFY COLUMN booking_date_time datetime;

SHOW TABLES;
DESC booking_table;
SELECT * FROM booking_table;