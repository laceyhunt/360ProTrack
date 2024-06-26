<?php
require('../../Front/db.php');
include("../../Front/auth_session.php");
$servername = "localhost";
$username = "root"; //$_SESSION['email'];
// $password = "root";	//not sure what to put here
$password = "";	//not sure what to put here
// $dbname = "cs360protrack";
$dbname = "protrack_db";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$currentUser=$_SESSION['email'];
$currentUserQuery = "SELECT * FROM users WHERE email='$currentUser'";
$currentUserResult=$conn->query($currentUserQuery);
$currentUserRow=$currentUserResult->fetch_assoc();
$currentUserType=$currentUserRow['type'];
$currentUserID=$currentUserRow["UID"];
if($currentUserType!=1){
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
                <p>Contact another student or your professor regarding your project. We could either have this send the actual email or it can just show their contact info.</p>
                <div class="dropdown">
                    <!-- <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                        Recipient
                    </button> -->
                    <input type="text" class="form-control dropdown-toggle" id="pwd" data-bs-toggle="dropdown" placeholder="Search for a recipient..." name="pswd">
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Jane Thomas</a></li>
                        <li><a class="dropdown-item" href="#">Bob Jones</a></li>
                        <li><a class="dropdown-item" href="#">Dwight Schrute</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <!-- A grey vertical navbar on the right side (1/5) -->
                <nav class="navbar navbar-expand-md flex-md-column" style="height: 100%; background-color: lightskyblue;">
                    <h1 style="color:black">
                        Instructor ProTrack
                    </h1>
                    <p>
                        Welcome <?php echo $currentUser?>
					</p>
					<p>
						<a class="nav-link" style="color:black" href="../../Front/logout.php">Logout</a>
					</p>
                    <br>
                    <!-- Links -->
                    <ul class="navbar-nav flex-column" id="navbar">
                        <li class="nav-item">
                            <a class="nav-link" style="color:black" href="instructor_home.php">HOME</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" style="color:black" href="instructor_contact.php">CONTACT</a>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" style="color:black" href="instructor_students.php">STUDENTS</a>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" style="color:black" href="instructor_syllabus.php">SYLLABUS</a>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" style="color:black" href="instructor_feedback.php">FEEDBACK</a>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" style="color:black" href="instructor_grades.php">GRADES</a>
                        </li>
                        <br>
                    </ul>
                </nav>
            </div>
        </div>
    </div>


</body>

</html>