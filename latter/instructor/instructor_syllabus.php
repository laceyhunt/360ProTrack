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
						$class=[];
						$index=0;
						while ($c_row = $c_result->fetch_assoc()) {
							echo "<h2>" . $c_row["course_name"] . "</h2><br>";
							$currentrow = $c_row["course_name"];
							$class[]=$c_row["CID"];
//							echo $class[];
							$sql = "SELECT * FROM projects JOIN courses ON courses.CID=projects.CID WHERE courses.IID='$currentUserID' AND courses.course_name='$currentrow'";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
								// output data of each row
								while ($row = $result->fetch_assoc()) {
									echo "<div class='row'><div class='col-md-4'>Project: " . $row["project_name"] . "</div>
									<div value=$class[$index] class='container col-md-4' type='button' data-bs-toggle='modal' data-bs-target='#syllabus'>
										<div class='card bg-primary text-white'>
											<div class='card-body'>View syllabus for course ID " . $class[$index] . "!</div>
										</div>
									</div></div>";
								}
							} else {
								echo "0 projects with syllabus<br>";
							}
							$index++;
							echo '<br>';
						}
					} else {
						echo "0 courses";
					}
					foreach($class as $x=>$y){
					echo "$x: $y <br>";
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
							<li class="nav-item active">
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

	<div class="modal" id="syllabus">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Syllabus:</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<form class="form" action="" method="post">
					<div class="row">
						<div class='col-md-2'>Project Title: </div>
						
						<div class='col-md-10'><textarea rows="1" cols="100" class="login-input" name="title" required />VideoGame</textarea></div>
					</div>
					<div class="row">
						<div class='col-md-2'>Total Points: </div>
						<div class='col-md-10'><textarea rows="1" cols="100" class="login-input" name="points" required />60</textarea></div>
					</div>
					<div class="row">
						<div class='col-md-2'>Learning Outcomes: </div>
						<div class='col-md-10'><textarea rows="3" cols="100" class="login-input" name="lo" required />By the end of the course, students are expected to be able to model, design, implement, and deploy a BCNF/3NF relational database application on a server for the end-users complete with web-based user interfaces.</textarea></div>
					</div>
					<div class="row">
						<div class='col-md-2'>Competencies Earned: </div>
						<div class='col-md-10'><textarea rows="3" cols="100" class="login-input" name="ce" required />Students will learn to use Flask, MySQL, CKEditor and integration of PDF based newsletter authoring and editing tools</textarea></div>
					</div>
					<div class="row">
						<div class='col-md-2'>Description of the Project: </div>
						<div class='col-md-10'><textarea rows="3" cols="100" class="login-input" name="dotp" required />An editorial board will moderate the submissions and thus will have the authority to edit or disavow content written by an author, or retract contents. Readers will be able to comment on articles, and on other readers' comments...</textarea></div>
					</div>
					<div class="row">
						<div class='col-md-2'>Requirements: </div>
						<div class="col-md-10">
							<table>
								<tr>
									<th style="padding: 15px;border: 1px solid black">System</th>
									<th style="padding: 15px;border: 1px solid black">Software</th>
								</tr>
								<tr>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="40" rows="1" class="login-input" name="system1"/>MySQL</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="40" rows="1" class="login-input" name="software1"/>CKEditor</textarea></td>
								</tr>
								<tr>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="40" rows="1" class="login-input" name="system2"/>XAMPP</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="40" rows="1" class="login-input" name="software2"/>WordTune</textarea></td>
								</tr>
								<tr>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="40" rows="1" class="login-input" name="system3"/></textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="40" rows="1" class="login-input" name="software3"/>PDFCreator</textarea></td>
								</tr>
								<tr>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="40" rows="1" class="login-input" name="system4"/></textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="40" rows="1" class="login-input" name="software4"/>Faker/Mockaroo</textarea></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="row">
						<div class='col-md-2'>Phases: </div>
						<div class="col-md-10">
							<table>
								<tr>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="5" rows="1" class="login-input" name="phases"/>4</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="20" rows="1"  class="login-input" name="phase1"/>7th Feb, 2024</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="20" rows="1" class="login-input" name="phase2"/>5th Mar, 2024</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="20" rows="1" class="login-input" name="phase3"/>3rd Apr, 2024</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="20" rows="1" class="login-input" name="phase4"/>10th May, 2024</textarea></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="row">
						<div class='col-md-2'>Deliverables: </div>
						<div class="col-md-10">
							<table>
								<tr>
									<th>Item</th>
									<th>Phase</th>
									<th>Mode</th>
									<th>Assessment Standard</th>
									<th>Necessity</th>
									<th>Weight</th>
								</tr>
								<tr>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="15" rows="1" class="login-input" name="dev_1_1">ER Diagram</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="5" rows="1"  class="login-input" name="dev_1_2">I</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="15" rows="1" class="login-input" name="dev_1_3">Image</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="25" rows="1" class="login-input" name="dev_1_4">Competent</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="15" rows="1" class="login-input" name="dev_1_5">Required</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="5" rows="1" class="login-input" name="dev_1_6">10%</textarea></td>
								</tr>
								<tr>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="15" rows="1" class="login-input" name="dev_2_1"/>BCNF Model</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="5" rows="1"  class="login-input" name="dev_2_2"/>II</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="15" rows="1" class="login-input" name="dev_2_3"/>Text</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="25" rows="1" class="login-input" name="dev_2_4"/>Accomplished</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="15" rows="1" class="login-input" name="dev_2_5"/>Required</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="5" rows="1" class="login-input" name="dev_2_6"/>20%</textarea></td>
								</tr>
								<tr>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="15" rows="1" class="login-input" name="dev_3_1">Query 1</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="5" rows="1"  class="login-input" name="dev_3_2"/>Open</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="15" rows="1" class="login-input" name="dev_3_3"/>Link</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="25" rows="1" class="login-input" name="dev_3_4"/>Competent</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="15" rows="1" class="login-input" name="dev_3_5"/>Expected</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="5" rows="1" class="login-input" name="dev_3_6"/>40%</textarea></td>
								</tr>
								<tr>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="15" rows="1" class="login-input" name="dev_4_1"/>User interface</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="5" rows="1"  class="login-input" name="dev_4_2"/>III</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="15" rows="1" class="login-input" name="dev_4_3"/>Link</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="25" rows="1" class="login-input" name="dev_4_4"/>Accomplished</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="15" rows="1" class="login-input" name="dev_4_5"/>Required</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="5" rows="1" class="login-input" name="dev_4_6"/>30%</textarea></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							Assignment Rubrics: <br>
						</div>
						<div class="col-md-10">
							<table>
								<tr>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="10" rows="2"  class="login-input" name="dev_1_2"/></textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="20" rows="2"  class="login-input" name="dev_1_2"/>0.0 - 3</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="20" rows="2"  class="login-input" name="dev_1_2"/>3.1 - 6</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="30" rows="2"  class="login-input" name="dev_1_2"/>6.1 - 10</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="5" rows="2"  class="login-input" name="dev_1_2"/>10</textarea></td>
								</tr>
								<tr>
									<th style="padding: 15px;border: 1px solid black"><textarea cols="10" rows="2"  class="login-input" name="dev_1_2"/>Category</textarea></th>
									<th style="padding: 15px;border: 1px solid black"><textarea cols="20" rows="2"  class="login-input" name="dev_1_2"/>Developing</textarea></th>
									<th style="padding: 15px;border: 1px solid black"><textarea cols="20" rows="2"  class="login-input" name="dev_1_2"/>Competent</textarea></th>
									<th style="padding: 15px;border: 1px solid black"><textarea cols="30" rows="2"  class="login-input" name="dev_1_2"/>Accomplished</textarea></th>
									<th style="padding: 15px;border: 1px solid black"><textarea cols="5" rows="2"  class="login-input" name="dev_1_2"/></textarea></th>
								</tr>
								<tr>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="10" rows="2"  class="login-input" name="dev_1_2"/>User Interface Design</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="20" rows="2"  class="login-input" name="dev_1_2"/>a. Some of the functionalities are implemented.<br>b. The interface did not meet aesthetic standards expected.<br>c. Tool choices were flawed.</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="20" rows="2"  class="login-input" name="dev_1_2"/>a. Choice of tools are reasonable.<br>b. Layout is acceptable and some of the functionalities are implemented.</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="30" rows="2"  class="login-input" name="dev_1_2"/>a. Student delivered a fully functional web interface for user interaction for all the expected functions.<br>b. Made prudent choice of tools.<br>c. No known bug or errors present.<br>d. The layout and color schemes are visually pleasant.</textarea></td>
									<td style="padding: 15px;border: 1px solid black"><textarea cols="5" rows="2"  class="login-input" name="dev_1_2"/></textarea></td>
								</tr>
							</table>
						</div>
					</div>
					<input type="submit" name="submit_syllabus" value="Submit Syllabus" class="login-button">
					</form>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function () {
			$("#edit").click(function () {
				//$('#div1').hide();
				$('#div1').show();
			});
			$("#btn2").click(function () {
				$.post("server.php", {
					name: "meow",
					city: "catsburg"
				},
						function (data, status) {
							alert("Data: " + data + "\nStatus: " + status);
						});
				newUrl = "server.php";
				$.ajax({url: newUrl, success: function (result) {
						$("#div1").html(result);
					}});
			});
		});
	</script>

</html>