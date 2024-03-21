<!-- <?php
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
?> -->
<!DOCTYPE html>
<html>

<head>
    <title>Student Feedback</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <!-- Add jQuery library -->
    <link rel='stylesheet' href='../../nav.css'>
</head>

<body>
    <div class="container-fluid">
        <div class="row">            
            <div class="col-md-8">
                <!-- Content for the rest of the page (left 4/5) -->
                <?php 
					$c_sql = "SELECT * FROM courses JOIN takes ON courses.CID=takes.CID WHERE takes.SID='$currentUserID'";
					$c_result=$conn->query($c_sql);
					if($c_result->num_rows > 0){
						while($c_row = $c_result->fetch_assoc()){
							echo "<h2>". $c_row["course_name"] ."</h2><br>";
							$currentrow=$c_row["course_name"];
							$sql= "SELECT * FROM projects JOIN courses ON courses.CID=projects.CID JOIN takes ON takes.CID=courses.CID WHERE takes.SID='$currentUserID' AND courses.course_name='$currentrow'";
							$result=$conn->query($sql);
							if ($result->num_rows > 0) {
								// output data of each row
								while($row = $result->fetch_assoc()) {
									echo "<li>Project: " . $row["project_name"]. "</li>";
								}
							} else{
								echo "No projects with feedback<br>";
							}
							echo '<br>';
						}
					}else {
						echo "0 courses";
					}
					
				?>
				
            </div>
			<!--SIDE NAVBAR-->
            <div class="col-md-4">
                <!-- A vertical navbar on the right side (1/5) -->
                <nav class="navbar navbar-expand-md flex-md-column" style="height: 100%; background-color: darkseagreen;">
                    <h1 style="color:black">
                        Student ProTrack
                    </h1>
                    <p>
                        <!<!-- Welcome <?php echo $currentUser?> -->
					</p>
                    <br>
                    <!-- Links -->
                    <ul class="navbar-nav flex-column" id="navbar">
                        <li class="nav-item active">
                            <a class="nav-link" style="color:black" href="student_home.php">HOME</a>
                        </li>
                        <li class="nav-item">
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