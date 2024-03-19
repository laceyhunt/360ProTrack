<?php
    // Enter your host name, database username, password, and database name.
    // If you have not set database password on localhost then set empty.
<<<<<<< HEAD
    $con = mysqli_connect("localhost","root","root","cs360protrack");
=======
    $con = mysqli_connect("localhost","root","","tyler_db");
>>>>>>> 35297c37b09cc815592370f3b00aa14a3443354d
    // Check connection
    if (mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
?>
