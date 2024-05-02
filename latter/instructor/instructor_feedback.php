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
$currentUser = $_SESSION['email'];
$currentUserQuery = "SELECT * FROM users WHERE email='$currentUser'";
$currentUserResult = $conn->query($currentUserQuery);
$currentUserRow = $currentUserResult->fetch_assoc();
$currentUserType = $currentUserRow['type'];
$currentUserID = $currentUserRow["UID"];
if ($currentUserType != 1) {
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
					$c_result = $conn->query($c_sql);
					if ($c_result->num_rows > 0) {
						while ($c_row = $c_result->fetch_assoc()) {
							echo "<h2>" . $c_row["course_name"] . "</h2><br>";
							$currentrow = $c_row["course_name"];
							$sql = "SELECT * FROM projects JOIN courses ON courses.CID=projects.CID WHERE courses.IID='$currentUserID' AND courses.course_name='$currentrow'";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
								// output data of each row
								while ($row = $result->fetch_assoc()) {
									echo "<div class='row'><div class='col-md-4'>Project: " . $row["project_name"] . "</div>
									<div class='container col-md-4' type='button' data-bs-toggle='modal' data-bs-target='#feedback'>
										<div class='card bg-primary text-white'>
											<div class='card-body'>View feedback!</div>
										</div>
									</div></div>";
								}
							} else {
								echo "No projects with feedback<br>";
							}
							echo '<br>';
						}
					} else {
						echo "0 courses";
					}
					?>
				</div>

				<!--SIDE NAVBAR-->
				<div class="col-md-4">
					<!-- A grey vertical navbar on the right side (1/5) -->
					<nav class="navbar navbar-expand-md flex-md-column" style="height: 100%; background-color: lightskyblue;">
						<h1 style="color:black">
							Instructor ProTrack
						</h1>
						<p>
							Welcome <?php echo $currentUser ?>
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
							<li class="nav-item">
								<a class="nav-link" style="color:black" href="instructor_contact.php">CONTACT</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" style="color:black" href="instructor_students.php">STUDENTS</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" style="color:black" href="instructor_syllabus.php">SYLLABUS</a>
							</li>
							<li class="nav-item active">
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

	<div class="modal" id="feedback">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Feedback:</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<!-- Modal body -->
				<div class="modal-body">
					<form class="form" action="" method="post">
					<div class="row">
						<div class='col-md-2'>Project Title: </div>
						<div class='col-md-10'>VideoGame</div>
					</div>
					<div class="row">
						<div class='col-md-2'>Team Number: </div>
						<div class='col-md-1'>6</div>
						<div class='col-md-2'>Date at Evaluation: </div>
						<div class='col-md-7'>10th May 2023</div>
					</div>
					<div class="row">
						<div class='col-md-2'>Phases: </div>
						<div class='col-md-1'>4</div>
						<div class='col-md-9'>
							<table>
								<tr>
									<td style="padding: 15px;border: 1px solid black"><input type="radio" class="login-input" name="phase" value="0" required>All</td>
									<td style="padding: 15px;border: 1px solid black"><input type="radio" class="login-input" name="phase" value="1" required>7th Feb, 2024</td>
									<td style="padding: 15px;border: 1px solid black"><input type="radio" class="login-input" name="phase" value="2" required>5th Mar, 2024</td>
									<td style="padding: 15px;border: 1px solid black"><input type="radio" class="login-input" name="phase" value="3" required>3rd Apr, 2024</td>
									<td style="padding: 15px;border: 1px solid black"><input type="radio" class="login-input" name="phase" value="4" required>10th May, 2024</td>
								</tr>
							</table>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							Deliverables:
							<table>
								<tr>
									<th style="padding: 15px;border: 1px solid black;text-align: center">Item</th>
									<th style="padding: 15px;border: 1px solid black;text-align: center">Mode</th>
									<th style="padding: 15px;border: 1px solid black;text-align: center">Points</th>
								</tr>
								<tr>
									<td style="padding: 15px;border: 1px solid black">ER Diagram</td>
									<td style="padding: 15px;border: 1px solid black">Image</td>
									<td style="padding: 15px;border: 1px solid black">7</td>
								</tr>
								<tr>
									<td style="padding: 15px;border: 1px solid black">BCNF Model</td>
									<td style="padding: 15px;border: 1px solid black">Text</td>
									<td style="padding: 15px;border: 1px solid black">5</td>
								</tr>
								<tr>
									<td style="padding: 15px;border: 1px solid black">Query 1</td>
									<td style="padding: 15px;border: 1px solid black">Link</td>
									<td style="padding: 15px;border: 1px solid black">9</td>
								</tr>
								<tr>
									<td style="padding: 15px;border: 1px solid black">User Interface</td>
									<td style="padding: 15px;border: 1px solid black">Link</td>
									<td style="padding: 15px;border: 1px solid black">3</td>
								</tr>
							</table>
						</div>
						<div class="col-md-8">
							
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							Rubric: <br>
							<textarea rows="10" cols="30" class="login-input" name="rubric" placeholder="Link to rubric goes here..." required /></textarea>
						</div>
						<div class="col-md-8">
							Assessment:
							<table>
								<tr>
									<td style="padding: 15px;border: 1px solid black"></td>
									<td style="padding: 15px;border: 1px solid black">0.0 - 3</td>
									<td style="padding: 15px;border: 1px solid black">3.1 - 6</td>
									<td style="padding: 15px;border: 1px solid black">6.1 - 10</td>
									<td style="padding: 15px;border: 1px solid black">10</td>
								</tr>
								<tr>
									<th style="padding: 15px;border: 1px solid black;text-align: center">Category</th>
									<th style="padding: 15px;border: 1px solid black;text-align: center">Developing</th>
									<th style="padding: 15px;border: 1px solid black;text-align: center">Competent</th>
									<th style="padding: 15px;border: 1px solid black;text-align: center">Accomplished</th>
									<th style="padding: 15px;border: 1px solid black;text-align: center"></th>
									
								</tr>
								<tr>
									<td style="padding: 15px;border: 1px solid black">User Interface design</td>
									<td style="padding: 15px;border: 1px solid black">a. Some of the functionalities are implemented.<br>b. The interface did not meet aesthetic standards.</td>
									<td style="padding: 15px;border: 1px solid black">a. Choice of tools are reasonable.<br>b. Layout is acceptable and some of the functionalities are present.</td>
									<td style="padding: 15px;border: 1px solid black">a. Student delivered a fully functional web interface for user interaction for all the expected functions.<br>b. Made prudent choices</td>
									<td style="padding: 15px;border: 1px solid black">3</td>
								</tr>
							</table>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div>Strengths</div>
							<table>
								<tr>
									<th style="padding: 15px;border: 1px solid black">Student</th>
									<th style="padding: 15px;border: 1px solid black">Instructor</th>
								</tr>
								<tr>
									<td style="padding: 15px;border: 1px solid black"><input type="textarea" class="login-input" name="strengths_student" placeholder="Comments go here..."/></td>
									<td style="padding: 15px;border: 1px solid black"><input type="textarea" class="login-input" name="strengths_instructor" placeholder="Comments go here..." required /></td>
								</tr>
							</table>
						</div>
						<div class="col-md-6">
							<div>Weaknesses</div>
							<table>
								<tr>
									<th style="padding: 15px;border: 1px solid black">Student</th>
									<th style="padding: 15px;border: 1px solid black">Instructor</th>
								</tr>
								<tr>
									<td style="padding: 15px;border: 1px solid black"><input type="textarea" class="login-input" name="weaknesses_student" placeholder="Comments go here..."/></td>
									<td style="padding: 15px;border: 1px solid black"><input type="textarea" class="login-input" name="weaknesses_instructor" placeholder="Comments go here..." required /></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div>Errors/Bugs</div>
							<table>
								<tr>
									<th style="padding: 15px;border: 1px solid black">Student</th>
									<th style="padding: 15px;border: 1px solid black">Instructor</th>
								</tr>
								<tr>
									<td style="padding: 15px;border: 1px solid black"><input type="textarea" class="login-input" name="errors_student" placeholder="Comments go here..."/></td>
									<td style="padding: 15px;border: 1px solid black"><input type="textarea" class="login-input" name="errors_instructor" placeholder="Comments go here..." required /></td>
								</tr>
							</table>
						</div>
						<div class="col-md-6">
							<div>Comments</div>
							<table>
								<tr>
									<th style="padding: 15px;border: 1px solid black">Student</th>
									<th style="padding: 15px;border: 1px solid black">Instructor</th>
								</tr>
								<tr>
									<td style="padding: 15px;border: 1px solid black"><input type="textarea" class="login-input" name="comments_student" placeholder="Comments go here..."/></td>
									<td style="padding: 15px;border: 1px solid black"><input type="textarea" class="login-input" name="comments_instructor" placeholder="Comments go here..." required /></td>
								</tr>
							</table>
						</div>
					</div>
						<input type="submit" name="submit_feedback" value="Submit Feedback" class="login-button">
					</form>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

</html>