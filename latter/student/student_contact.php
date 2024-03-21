<?php
require('../../Front/db.php');
include("../../Front/auth_session.php");
// include 'update_project_name.php';
$servername = "localhost";
$username = "root"; //$_SESSION['email'];
$password = "root";	//not sure what to put here
//$password = "";	//not sure what to put here
$dbname = "cs360protrack";
//$dbname = "protrack_db";
// Create connection and verify student
$conn = new mysqli($servername, $username, $password, $dbname);
$currentUser=$_SESSION['email'];
$currentUserQuery = "SELECT * FROM users WHERE email='$currentUser'";
$currentUserResult=$conn->query($currentUserQuery);
$currentUserRow=$currentUserResult->fetch_assoc();
$currentUserType=$currentUserRow['type'];
$currentUserID=$currentUserRow["UID"];
if($currentUserType!=0){
	session_abort();
	header("Location: ../../Front/login.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Contact</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel='stylesheet' href='../../nav.css'>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <h2 style="text-align: center;">
                    <br>
                    Contact
                </h2>
                <!-- Content for the rest of the page (left 4/5) -->
                <p>Search for the contact information of another student or your professor to discuss your project.</p>
                <div class="dropdown">
                    <!-- <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                        Recipient
                    </button> -->
                    <input type="text" class="form-control dropdown-toggle" id="pwd" data-bs-toggle="dropdown" id="contactSearch" placeholder="Search for a student or instructor..." name="contactSearch">
                    <ul class="dropdown-menu" id="contactList">
                    <?php
                    //students
                    $sql = "SELECT first_name, last_name, email FROM `users` WHERE type='0'";
                    $collab = $conn->query($sql);
                    if ($collab->num_rows > 0) {
                        // output data of each row
                        while($students_row = $collab->fetch_assoc()) {
                        echo '<li><a class="dropdown-item text-success" href="#" data-email="' . $students_row["email"] . '"> ' . $students_row["first_name"] . ' ' . $students_row["last_name"] . ': '. $students_row["email"] .' </a></li>';
                        }
                    } else {
                        echo '<li><a class="dropdown-item" href="#"> No students to contact. </a></li>';
                    }

                    //instructors
                    $sql = "SELECT first_name, last_name, email FROM `users` WHERE type='1'";
                    $collab = $conn->query($sql);
                    if ($collab->num_rows > 0) {
                        // output data of each row
                        while($students_row = $collab->fetch_assoc()) {
                        echo '<li><a class="dropdown-item text-primary" href="#" data-email="' . $students_row["email"] . '"> ' . $students_row["first_name"] . ' ' . $students_row["last_name"] . ': '. $students_row["email"] .' </a></li>';
                        }
                    } else {
                        echo '<li><a class="dropdown-item" href="#"> No instructors to contact. </a></li>';
                    }
                    ?>

                    <script>
                        var dropdownMenu = document.getElementById('contactList');
                        // Add click event listener to the dropdown menu
                        dropdownMenu.addEventListener('click', function(event) {
                            // Check if the clicked element is a dropdown item
                            if (event.target.classList.contains('dropdown-item')) {
                                // Get the email from the data attribute
                                var email = event.target.getAttribute('data-email');
                                // Display the email
                                document.getElementById('emailDisplay').innerHTML = 'Selected Email: ' + email;
                            }
                        });
                    </script>

            
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <!-- A grey vertical navbar on the right side (1/5) -->
                <nav class="navbar navbar-expand-md flex-md-column" style="height: 100%; background-color: darkseagreen;">
                    <h1 style="color:black">
                        Student ProTrack
                    </h1>
                    <br>
                    <!-- Links -->
                    <ul class="navbar-nav flex-column" id="navbar">
                        <li class="nav-item">
                            <a class="nav-link" style="color:black" href="student_home.php">HOME</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" style="color:black" href="student_contact.php">CONTACT</a>
                        </li>
                        <br>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</body>

</html>