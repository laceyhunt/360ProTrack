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
									echo "<div class='row'><div class='col-md-4'>Project: " . $row["project_name"]. "</div>
									<div class='container col-md-4' type='button' data-bs-toggle='modal' data-bs-target='#syllabus'>
										<div class='card bg-primary text-white'>
											<div class='card-body'>View syllabus!</div>
										</div>
									</div></div>";
								}
							} else{
								echo "0 projects with syllabus<br>";
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
								<div class='row'>
					<div class='col-md-2'>Project Title:</div>
					<div class='col-md-10'>BlogBase Database for Current Affairs</div>
					<br><br><div class='col-md-2'>Total Points:</div>
					<div class='col-md-10'>60</div>
					<br><br><div class='col-md-2'>Learning Outcomes:</div>
					<div class='col-md-10'>By the end of the course, students are expected to be able to model, design, implement, and deploy a BCNF/3NF relational database application on a server for the end-users complete with web-based user interfaces.</div>
					<br><br><div class='col-md-2'>Competencies Earned:</div>
					<div class='col-md-10'>Students will learn to use Flask, MySQL, CKEditor and integration of PDF based newsletter authoring and editing tools</div>
					<br><br><div class='col-md-2'>Description of the Project:</div>
					<div class='col-md-10'>An editorial board will moderate the submissions and thus will have the authority to edit or disavow content written by an author, or retract contents. Readers will be able to comment on articles, and on other readers' comments...</div>
					<br><br><br><div class='col-md-2'>Requirements:</div>
					<div class='col-md-10'>
					<table>
						<tr>
						  <th style='padding: 15px;border: 1px solid black;'>System</th>
						  <th style='padding: 15px;border: 1px solid black;'>Software</th>
						</tr>
						<tr>
						  <td style='padding: 15px;border: 1px solid black;'>MySQL</td>
						  <td style='padding: 15px;border: 1px solid black;'>CKEditor</td>
						</tr>
						<tr>
						  <td style='padding: 15px;border: 1px solid black;'>XAMPP</td>
						  <td style='padding: 15px;border: 1px solid black;'>WordTune</td>
						</tr>
						<tr>
							<td style='padding: 15px;border: 1px solid black;'></td>
							<td style='padding: 15px;border: 1px solid black;'>PDFCreator</td>
						</tr>
						<tr>
							<td style='padding: 15px;border: 1px solid black;'></td>
							<td style='padding: 15px;border: 1px solid black;'>Faker/Mockaroo</td>
						</tr>
					</table><br><br>
					</div>
					<br><br><div class='col-md-2'>Number of Phases:</div>
					<div class='col-md-10'><table>
						<tr>
						  <th style='padding: 15px;border: 1px solid black;'>4</th>
						  <th style='padding: 15px;border: 1px solid black;'>7th February, 2023</th>
						  <th style='padding: 15px;border: 1px solid black;'>5th March, 2023</th>
						  <th style='padding: 15px;border: 1px solid black;'>3rd April, 2023</th>
						  <th style='padding: 15px;border: 1px solid black;'>10th May, 2023</th>
						</tr>
					</table></div><br><br>
					<br><br><div class='col-md-2'>Deliverables:</div>
					<div class='col-md-10'>
						<table>
						<tr>
						  <th style='padding: 15px;border: 1px solid black;'>Item</th>
						  <th style='padding: 15px;border: 1px solid black;'>Phase</th>
						  <th style='padding: 15px;border: 1px solid black;'>Mode</th>
						  <th style='padding: 15px;border: 1px solid black;'>Assessent Standard</th>
						  <th style='padding: 15px;border: 1px solid black;'>Necessity</th>
						  <th style='padding: 15px;border: 1px solid black;'>Weight</th>
						</tr>
						<tr>
						  <td style='padding: 15px;border: 1px solid black;'>ER Diagram</td>
						  <td style='padding: 15px;border: 1px solid black;'>I</td>
						  <td style='padding: 15px;border: 1px solid black;'>Image</td>
						  <td style='padding: 15px;border: 1px solid black;'>Competent</td>
						  <td style='padding: 15px;border: 1px solid black;'>Required</td>
						  <td style='padding: 15px;border: 1px solid black;'>10%</td>
						</tr>
						<tr>
						  <td style='padding: 15px;border: 1px solid black;'>BCNF Model</td>
						  <td style='padding: 15px;border: 1px solid black;'>II</td>
						  <td style='padding: 15px;border: 1px solid black;'>Text</td>
						  <td style='padding: 15px;border: 1px solid black;'>Accomplished</td>
						  <td style='padding: 15px;border: 1px solid black;'>Required</td>
						  <td style='padding: 15px;border: 1px solid black;'>20%</td>
						</tr>
						<tr>
						  <td style='padding: 15px;border: 1px solid black;'>Query 1</td>
						  <td style='padding: 15px;border: 1px solid black;'>Open</td>
						  <td style='padding: 15px;border: 1px solid black;'>Link</td>
						  <td style='padding: 15px;border: 1px solid black;'>Competent</td>
						  <td style='padding: 15px;border: 1px solid black;'>Expected</td>
						  <td style='padding: 15px;border: 1px solid black;'>40%</td>
						</tr>
						<tr>
						  <td style='padding: 15px;border: 1px solid black;'>User Interface</td>
						  <td style='padding: 15px;border: 1px solid black;'>III</td>
						  <td style='padding: 15px;border: 1px solid black;'>Link</td>
						  <td style='padding: 15px;border: 1px solid black;'>Accomplished</td>
						  <td style='padding: 15px;border: 1px solid black;'>Required</td>
						  <td style='padding: 15px;border: 1px solid black;'>30%</td>
						</tr>
						</table><br><br>
					</div>
					<br><br><div class='col-md-2'>Assignment Rubrics:</div>
					<div class='col-md-10'>
						<table>
						<tr>
						  <td style='padding: 15px;border: 1px solid black;'>Assessment</td>
						  <td style='padding: 15px;border: 1px solid black;'>0.0 - 3</td>
						  <td style='padding: 15px;border: 1px solid black;'>3.1 - 6</td>
						  <td style='padding: 15px;border: 1px solid black;'>6.1 - 10</td>
						  <td style='padding: 15px;border: 1px solid black;'>10</td>
						</tr>
						<tr>
						  <th style='padding: 15px;border: 1px solid black;'>Category</th>
						  <th style='padding: 15px;border: 1px solid black;'>Developing</th>
						  <th style='padding: 15px;border: 1px solid black;'>Competent</th>
						  <th style='padding: 15px;border: 1px solid black;'>Accomplished</th>
						  <th style='padding: 15px;border: 1px solid black;'></th>
						</tr>
						<tr>
							<td style='padding: 15px;border: 1px solid black;'>User Interface Design</td>
							<td style='padding: 15px;border: 1px solid black;'>a. Some of the functionalities are implemented.<br>b. The interface did not meet aesthetic standards expected.<br>c. Tool choices were flawed.</td>
							<td style='padding: 15px;border: 1px solid black;'>a. Choice of tools are reasonable.<br>b. Layout is acceptable and some of the functionalities are implemented.</td>
							<td style='padding: 15px;border: 1px solid black;'>a. Student delivered a fully functional web interface for user interaction for all the expected functions.<br>b. Made prudent choice of tools.<br>c. No known bug or errors present.<br>d. The layout and color schemes are visually pleasant.</td>
							<td style='padding: 15px;border: 1px solid black;'></td>
						</tr>
					</table><br><br>
					</div>
						<div class='container col-md-4' type='button'>
							<div class='card bg-primary text-white'>
								<button id="edit" type="button">Show Div 1</button>
								<div class='card-body'>Edit syllabus!</div>
							</div>
							<div id="div1" style="display:none;">
								Hello
							</div>
						</div><br><br>
								</div>
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

<script>
			$(document).ready(function(){
				$("#edit").click(function(){
					//$('#div1').hide();
					$('#div1').show();
				});
				$("#btn2").click(function(){
					$.post("server.php",{
						name: "meow",
						city: "catsburg"
					},
					function(data,status){
						alert("Data: "+data+"\nStatus: "+status);
					});
					newUrl="server.php";
					$.ajax({url: newUrl, success:function(result){
						$("#div1").html(result);
					}});
				});
			});
		</script>

</html>