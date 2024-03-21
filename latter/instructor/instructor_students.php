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
					$course_sql = "SELECT * FROM courses WHERE courses.IID='$currentUserID'";
					$course_result=$conn->query($course_sql);
					if($course_result->num_rows > 0){
						while($course_row = $course_result->fetch_assoc()){
							echo "<h2>". $course_row["course_name"] ."</h2><br>";
							$currentrow=$course_row["course_name"];
							$sql= "SELECT * FROM users JOIN takes JOIN courses ON users.UID=takes.SID AND takes.CID=courses.CID WHERE courses.IID='$currentUserID' AND users.type='0' AND courses.course_name='$currentrow'";
							$result=$conn->query($sql);
							if ($result->num_rows > 0) {
								// output data of each row
								while($row = $result->fetch_assoc()) {
									echo "<li>Name: " . $row["first_name"]. " " . $row["last_name"]. " | Email: " . $row["email"]. "</li>";
								}
							} else{
								echo "0 students in course<br>";
							}
							echo '<br>';
						}
					}else {
						echo "0 courses";
					}
					
				?>
				<div class="container mt-3 col-md-4" type="button" data-bs-toggle="modal" data-bs-target="#assign">
					<div class="card bg-primary text-white">
						<div class="card-body">Add a student to a course!</div>
					</div>
				</div>
            </div>
			
			<div class="modal" id="assign">
                    <?php
						if (isset($_POST['students'])) {
							$name = stripslashes($_REQUEST['students']);
							$name = mysqli_real_escape_string($con, $name);
							$sid_query="SELECT UID FROM users WHERE 'users.UID=$id AND users.type='0'";
							$sid_result=$conn->query($sid_query);
							$course = stripslashes($_REQUEST['courses']);
							$course = mysqli_real_escape_string($con, $course);
							$cid_query="SELECT CID FROM courses WHERE courses.name=$course";
							$cid_result=$conn->query($cid_query);
							$assign_query="INSERT into `takes` (SID,CID)
											VALUES ('$sid_result','$cid_result')";
							$assign_result=$conn->query($assign_query);
						}else{
					?><div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Assign a student to a course</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal body -->
                           <div class="dropdown">
					<form class="form" method="post" name="students" action="<?php echo $PHP_SELF; ?>">
                    <input type="text" class="form-control dropdown-toggle" id="students" data-bs-toggle="dropdown" placeholder="Students" name="students" required>
                    <ul class="dropdown-menu">
						<?php
							$students_sql= "SELECT * FROM users WHERE users.type='0'";
							$students_result=$conn->query($students_sql);
							if ($students_result->num_rows > 0) {
								// output data of each row
								while($students_row = $students_result->fetch_assoc()) {
									$fname=$students_row["first_name"];
									$lname=$students_row["last_name"];
									$id=$students_row["UID"];
									?><option value="<?php $id?>"><a class='dropdown-item' href='#'><?php echo $fname; echo $lname;?></a></option><?php
								}
							}
						?>
                    </ul><br>
					
					<input type="text" class="form-control dropdown-toggle" id="courses" data-bs-toggle="dropdown" placeholder="Courses" name="courses" required>
                    <ul class="dropdown-menu">
						<?php
							$courses_sql= "SELECT * FROM courses WHERE courses.IID='$currentUserID'";
							$courses_result=$conn->query($courses_sql);
							if ($courses_result->num_rows > 0) {
								// output data of each row
								while($courses_row = $courses_result->fetch_assoc()) {
									$cname=$courses_row["course_name"];
									echo "<li><a class='dropdown-item' href='#'>$cname</a></li>";
								}
							}
						?>
                    </ul><br>
					<input type="submit" value="Enroll student" name="submit" class="login-button"/>
					</form>
					<?php
						}?>
                </div>				
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
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
						<li class="nav-item active">
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