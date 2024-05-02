<?php
    // Enter your host name, database username, password, and database name.
    // If you have not set database password on localhost then set empty.
    //  $con = mysqli_connect("localhost","root","root","cs360protrack");
	$con = mysqli_connect("localhost","root","","protrack_db");
    // Check connection
    if (mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }



    // host files in browser 
    // common db for everyone, instructor member of all and students update info