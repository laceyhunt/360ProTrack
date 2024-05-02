<?php
require('../../Front/db.php');
include("../../Front/auth_session.php");
// include 'update_project_name.php';
$servername = "localhost";
$username = "root"; //$_SESSION['email'];
// $password = "root";	//not sure what to put here
$password = "";	//not sure what to put here
// $dbname = "cs360protrack";
$dbname = "protrack_db";
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
    <title>Student Home</title>
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
                <h2 style="text-align: center;">
                <br>
                    Projects
                </h2>
                <!-- Course Cards -->
                <div class="container-fluid">
				
                    <div class="row" style="height: 100px;">
						<?php 
							$sql = "SELECT projects.project_name FROM projects JOIN works_on JOIN users ON works_on.PID=projects.PID AND works_on.SID=users.UID WHERE users.type='0'AND users.email='$currentUser'";
							$projects = $conn->query($sql);
								
							if ($projects->num_rows > 0) {
								// output data of each row
								while($projects_row = $projects->fetch_assoc()) {
									echo '
						
								  <div class="container mt-3 col-md-4 project-card" type="button" data-bs-toggle="modal" data-bs-target="#course1" data-project-name="' . $projects_row["project_name"] . '" >
										<div class="card bg-success text-white">
											<div class="card-body">' . $projects_row["project_name"] . '</div>
										</div>
									</div>
                                    
									';
								}
							  } else {
								echo '<div class="container mt-3 col-md-4">
											<div class="card bg-success text-white">
												<div class="card-body">No Projects</div>
											</div>
										</div>';
							  }
							echo '<div class="container mt-3 col-md-4" type="button" data-bs-toggle="modal" data-bs-target="#newcourse">
									<div class="card bg-success text-white">
										<div class="card-body">Add a new project!</div>
									</div>
								</div>';
						?>
                        
                        
                        <script>
                            $(document).ready(function() {
                                // Attach click event listener to project cards
                                $('.project-card').click(function() {
                                    // Get project name from data attribute
                                    var projectName = $(this).data('project-name');
                                    // console.log(window.location.href);
                                    // var currentUrl = window.location.href;
                                    // var sendUrl=window.location.href+'/../update_project_name.php';
                                    // console.log(sendUrl);
                                    // Send project name to the same PHP script using AJAX
                                    $.ajax({
                                        type: 'POST',
                                         url: 'update_project_name.php', // PHP script to handle updating the session variable
//                                        url: sendUrl,
                                        data: { projectName: projectName },
                                        success: function(response) {
                                            console.log('Project Name Updated:', projectName);
                                            // Optionally, you can reload the page or update the UI here

//                                            document.cookie="projectName="+$projectName;
//                                            console.log(document.cookie);

                                            $('#projectName').text(projectName);
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('Error:', error);
                                        }
                                    });
                                });
                            });

                        </script>

                    </div>

                </div>
                <!-- The Modal -->
				
				<!--ADD A NEW COURSE MODAL-->
                <div class="modal" id="newcourse">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Please enter the project info:</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal body -->
                           
							<?php 
								if (isset($_POST['project_name'])) {
									$project_name = stripslashes($_REQUEST['project_name']);    // removes backslashes
									$project_name = mysqli_real_escape_string($con, $project_name);
									$email=$_SESSION['email'];
									$SID_query = "SELECT UID FROM `users` WHERE email='$email'";
									$SID = $conn->query($SID_query);
									$SID_row=$SID->fetch_assoc();
									$check_query    = "SELECT projects.project_name FROM `projects` JOIN `works_on` JOIN `users` ON works_on.SID=users.UID AND projects.PID=works_on.PID WHERE users.type='0' AND users.email='$currentUser' AND projects.project_name='$project_name'";
									   $check_result = mysqli_query($con, $check_query) or die(mysql_error());
									   $check_rows = mysqli_num_rows($check_result);
									if ($check_rows == 0) {
										$projects_query    = "INSERT into `projects` (project_name)
															VALUES ('$project_name')";
										$projects_result   = mysqli_query($con, $projects_query);
										$PID_query    = "SELECT PID FROM `projects` WHERE project_name='$project_name'";
										$PID = $conn->query($PID_query) or die(mysql_error());
										$PID_row=$PID->fetch_assoc();
										$workson_query = "INSERT into `works_on` (SID,PID)
															VALUES ('$SID_row[UID]',$PID_row[PID])";
										$workson_result = mysqli_query($con, $workson_query);
										header("Location: student_home.php");
									}else{
										echo '<div>There is already a project with this name!</div>';
									}
									
								}else{
									?>
									 <div class="modal-body">
										<form class="form" action="" method="post">
												<input type="text" class="login-input" name="project_name" placeholder="Project name" required /><br><br>
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
                                <?php
                                    // accept cookie from browser
//                                    $projectName=$_COOKIE['projectName'];
                                    // echo $_COOKIE['projectName'];
                                    // echo $projectName;
                                ?>
                                <h4 class="modal-title" ><?php // echo $projectName; ?></h4>

                                <!-- <h4 class="modal-title">Project Title:&nbsp;</h4> -->
                                 <h4 class="modal-title" id="projectName">Title</h4> 
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <?php
                                // var_dump($_GET); // Debugging to inspect the contents of $_GET
                                // $projectName = $_GET['variable_name']; // Access the variable from the URL
                                // echo $projectName; // Use the variable
                            ?>

                            <!-- Modal body -->
                            <div class="modal-body">
								<a>Collaborators:</a><br><br>
                                <?php
                                    // $projectName = $_POST['projectName'];
                                    // Get the current URL
                                    // $currentUrl = "http" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 's' : '') . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

                                    // echo $currentUrl;
                                    // echo "____";

                                    // Get the full URL with query parameters
                                    // $fullUrl = $currentUrl . (empty($_SERVER['QUERY_STRING']) ? '' : '?' . $_SERVER['QUERY_STRING']);

                                    // echo $fullUrl;
                                    // echo''.$projectName.'';
                                    // $sql = "SELECT users.first_name FROM users JOIN works_on JOIN projects ON works_on.PID=projects.PID AND works_on.SID=users.UID WHERE users.type='0' AND projects.project_name='$projectName";

                                    //instructor
                                    $sql = "SELECT users.first_name, users.last_name FROM users JOIN projects ON projects.IID=users.UID WHERE users.type='1'";
                                    $collab = $conn->query($sql);
                                    if ($collab->num_rows > 0) {
                                        // output data of each row
                                        while($students_row = $collab->fetch_assoc()) {
                                        echo '<p class="text-primary">&nbsp;&nbsp;&nbsp;' . $students_row["first_name"] . ' ' . $students_row["last_name"] . '</p>';
                                        }
                                    } else {
                                    echo '<p class="text-primary"> No instructor collaborators. </p>';
                                    }
                                    //students
                                    $sql = "SELECT users.first_name, users.last_name FROM users JOIN works_on JOIN projects ON works_on.PID=projects.PID AND works_on.SID=users.UID WHERE users.type='0'";
                                    $collab = $conn->query($sql);
                                    if ($collab->num_rows > 0) {
                                        // output data of each row
                                        while($students_row = $collab->fetch_assoc()) {
                                        echo '<p class="text-success">&nbsp;&nbsp;&nbsp;' . $students_row["first_name"] . ' ' . $students_row["last_name"] . '</p>';
                                        }
                                    } else {
                                    echo '<p class="text-success"> No student collaborators. </p>';
                                    }
                                ?>
								<a href="student_plan.php">View/Edit Project Plan</a><br>
								<a href="student_syllabus.html">View Syllabus</a><br>
								<a href="student_feedback.php">View Instructor Feedback</a><br>
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
                <!-- A vertical navbar on the right side (1/5) -->
                <nav class="navbar navbar-expand-md flex-md-column" style="height: 100%; background-color: darkseagreen;">
                    <h1 style="color:black">
                        Student ProTrack
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