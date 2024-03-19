<?php
require('../../Front/db.php');
include("../../Front/auth_session.php");
$servername = "localhost";
$username = "root"; //$_SESSION['email'];
$password = "root";	//not sure what to put here
$dbname = "cs360protrack";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
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
                <h2 style="text-align: center;">
                <br>
                    Courses
                </h2>
                <!-- Course Cards -->
                <div class="container-fluid">
				
                    <div class="row" style="height: 100px;">
						<?php 
							$sql = "SELECT courses.course_name FROM courses JOIN instructs JOIN users ON instructs.IID=users.UID AND courses.CID=instructs.CID WHERE users.type='1'";
							$courses = $conn->query($sql);
								
							if ($courses->num_rows > 0) {
								// output data of each row
								while($courses_row = $courses->fetch_assoc()) {
									echo '
						
								  <div class="container mt-3 col-md-4" type="button" data-bs-toggle="modal" data-bs-target="#course1">
										<div class="card bg-primary text-white">
											<div class="card-body">' . $courses_row["course_name"] . '</div>
										</div>
									</div>
									';
								}
							  } else {
								echo '<div class="container mt-3 col-md-4">
											<div class="card bg-primary text-white">
												<div class="card-body">No courses</div>
											</div>
										</div>';
							  }
							echo '<div class="container mt-3 col-md-4" type="button" data-bs-toggle="modal" data-bs-target="#newcourse">
									<div class="card bg-primary text-white">
										<div class="card-body">Add a new course!</div>
									</div>
								</div>';
						?>
                        
                        
                    </div>

                </div>
                <!-- The Modal -->
				
				<!--ADD A NEW COURSE MODAL-->
                <div class="modal" id="newcourse">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Please enter the course info:</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal body -->
                           
							<?php 
								
								
								if (isset($_POST['course_name'])) {
									$course_name = stripslashes($_REQUEST['course_name']);    // removes backslashes
									$course_name = mysqli_real_escape_string($con, $course_name);
									$email=$_SESSION['email'];
									$IID_query = "SELECT UID FROM `users` WHERE email='$email'";
									$IID = $conn->query($IID_query);
									$IID_row=$IID->fetch_assoc();
									$check_query    = "SELECT * FROM `courses` WHERE course_name='$course_name' AND IID=$IID_row[UID]";
									   $check_result = mysqli_query($con, $check_query) or die(mysql_error());
									   $check_rows = mysqli_num_rows($check_result);
									if ($check_rows == 0) {
										$courses_query    = "INSERT into `courses` (course_name,IID)
															VALUES ('$course_name',$IID_row[UID])";
										$courses_result   = mysqli_query($con, $courses_query);
										$CID_query    = "SELECT CID FROM `courses` WHERE course_name='$course_name' AND courses.IID='$IID_row[UID]'";
										$CID = $conn->query($CID_query) or die(mysql_error());
										$CID_row=$CID->fetch_assoc();
										$instructs_query = "INSERT into `instructs` (IID,CID)
															VALUES ('$IID_row[UID]',$CID_row[CID])";
										$instructs_result = mysqli_query($con, $instructs_query);
										header("Location: instructor_home.php");
									}else{
										echo '<div>There is already a course with this name!</div>';
									}
									
								}else{
									?>
									 <div class="modal-body">
										<form class="form" action="" method="post">
												<input type="text" class="login-input" name="course_name" placeholder="Course name" required /><br><br>
												<input type="submit" name="submit" value="Register" class="login-button">
											 </form>
									</div>
							<?php
								}
							?>						
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
				
				<!--MODAL THAT APPEARS WHEN CLICKING ON CLASS-->
				<div class="modal" id="course1">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title"></h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
								<a>View/Add/Remove Students</a><br><br>
								<a>View/Edit Syllabus</a><br><br>
								<a>View/Edit Feedback</a><br><br>
								<a>View/Edit Grades</a><br><br>
								<?php
//									if (isset($_GET[])){
//										
//									}else{
//										echo 'Remove course';
//									}
//								?><br><br>
                                <?php 
									$sql = "SELECT PID, IID, CID FROM projects WHERE CID='383' ORDER BY PID";
									$result = $conn->query($sql);
								
								if ($result->num_rows > 0) {
									// output data of each row
									while($row = $result->fetch_assoc()) {
									  echo "PID: " . $row["PID"]. " - IID: " . $row["IID"]. " - CID: " . $row["CID"]. "<br>";
									}
								  } else {
									echo "0 results";
								  }
								 ?>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
				
				
            </div>
			
			
			
			
			
			
			
			
			
			<!--SIDE NAVBAR-->
            <div class="col-md-4">
                <!-- A grey vertical navbar on the right side (1/5) -->
                <nav class="navbar bg-white navbar-expand-md flex-md-column" style="height: 100%;">
                    <h1 style="color:black">
                        Instructor ProTrack
                    </h1>
                    <br>
                    <!-- Links -->
                    <ul class="navbar-nav flex-column" id="navbar">
                        <li class="nav-item active">
                            <a class="nav-link" style="color:black" href="instructor_home.php">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" style="color:black" href="instructor_contact.html">CONTACT</a>
                        </li>
                        <br>
                    </ul>
                </nav>
            </div>
			
        </div>
    </div>
</body>

</html>