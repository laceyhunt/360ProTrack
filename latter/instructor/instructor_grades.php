<?php
require('../../Front/db.php');
include("../../Front/auth_session.php");
$servername = "localhost";
$username = "root"; //$_SESSION['email'];
$password = "root";	//not sure what to put here
$dbname = "cs360protrack";
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
    <title>Instructor Home</title>
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
                <!-- Content for the rest of the page (left 4/5) -->
                <?php 
					$c_sql = "SELECT * FROM courses WHERE courses.IID='$currentUserID'";
					$c_result=$conn->query($c_sql);
					if($c_result->num_rows > 0){
						while($c_row = $c_result->fetch_assoc()){
							echo "<h2>". $c_row["course_name"] ."</h2><br>";
							$currentrow=$c_row["course_name"];
							$sql= "SELECT * FROM projects JOIN courses ON courses.CID=projects.CID WHERE courses.IID='$currentUserID' AND courses.course_name='$currentrow'";
							$result=$conn->query($sql);
							if ($result->num_rows > 0) {
								// output data of each row
								while($row = $result->fetch_assoc()) {
									echo "<li>Project: " . $row["project_name"]. "</li>";
								}
							} else{
								echo "0 grades for projects<br>";
							}
							echo '<br>';
						}
					}else {
						echo "0 courses";
					}
					
				?>
				<div class="container mt-3 col-md-4" type="button" data-bs-toggle="modal" data-bs-target="#assign">
					<div class="card bg-primary text-white">
						<div class="card-body">Add a syllabus for a course!</div>
					</div>
				</div>
            </div>
			
			
			
			
			
			
			
			
			
			<!--SIDE NAVBAR-->
            <div class="col-md-4">
                <!-- A grey vertical navbar on the right side (1/5) -->
                <nav class="navbar navbar-expand-md flex-md-column" style="height: 100%; background-color: lightskyblue;">
                    <h1 style="color:black">
                        Instructor ProTrack
                    </h1>
					<p>
						Welcome <?php echo $currentUser?>
					</p>
                    <br>
                    <!-- Links -->
                    <ul class="navbar-nav flex-column" id="navbar">
                        <li class="nav-item">
                            <a class="nav-link" style="color:black" href="instructor_home.php">HOME</a>
                        </li>
                        <li class="nav-item">
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
						<li class="nav-item active">
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