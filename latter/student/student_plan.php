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
    <title>Student Plan</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <!-- Add jQuery library -->
    <link rel='stylesheet' href='../../nav.css'>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
    
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
    
        th {
            background-color: #f2f2f2;
        }
        .chart-container {
            border: 1px solid #ccc; /* Add border around the container */
            padding: 10px; /* Add padding to the container */
        }
        .grey-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }

        .chart-wrapper {
            text-align: center; /* Center the image horizontally */
            margin-bottom: 10px; /* Add margin below the image */
        }

        .chart-wrapper img {
            width: 100%; /* Make the image fill its container */
            display: block; /* Ensure the image is displayed as a block element */
        }

    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">            
            <div class="col-md-8">
                <!-- Content for the rest of the page (left 4/5) -->
                <h1 style="text-align: center">
                    Project Plan
                </h1>
                <!-- Link to the Flask route -->
                <!-- <a href="http://localhost:5000/project">View Project 1</a> -->
                <!-- <button id="update_project_plan_button" onclick="getDBdata()">View Project Data</button> -->

                <!-- <div class="col-md-3"> -->
                <div class="grey-box">
                    <h4>Project Title</h4>
                    <!-- <p>{{ project_title }}</p> -->
                    <p>VideoGame</p>
                </div>
                <div class="grey-box">
                    <h4>Team Members</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- {% for member in team_members %}
                            <tr>
                                <td>{{ member[0] }} {{ member[1] }}</td>
                                <td>{{ member[2] }}</td>
                            </tr>
                            {% endfor %} -->
                            <tr>
                                <td>Tim Tom</td>
                                <td>timmy@gmail.com</td>
                            </tr>
                            <tr>
                                <td>Jane Smoo</td>
                                <td>jsmoo@gmail.com</td>
                            </tr>
                            <tr>
                                <td>John Swan</td>
                                <td>jswan@gmail.con</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- </div> -->
                <div class="grey-box">
                    <h4>Meetings</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Place</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" value="Monday, 12:00"></td>
                                <td><input type="text" value="DeArmond 223"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="grey-box">
                    <h4>Deliverables</h4>
                
                <table id="taskTable">
                    <tr>
                        <th>TASK</th>
                        <th>DURATION</th>
                        <th>DEPENDENCIES</th>
                        <th>DESCRIPTION</th>
                    </tr>
                </table>
                
                
                <br>
                
                <button onclick="addTask()">Add Task</button>
                <button id="update_project_plan_button" onclick="exportCSV()">Update Project Plan</button>
                <!-- <form method="post">
                    <input id="update_project_plan_button" onclick="exportCSV()" type="submit" value="test">
                </form> -->
                
                <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
                <script>
                $(document).ready(function(){
                    // Function to refresh the images
                    function refreshImages() {
                        // Reload the images by changing their src attribute
                        $('#pert').attr('src', 'pert.png?' + new Date().getTime()); // Add a random query parameter to force browser to fetch new image
                        $('#gantt').attr('src', 'gantt.png?' + new Date().getTime());
                    }

                    // Function to fetch images at regular intervals
                    function fetchImagesAtInterval() {
                        // Set interval to refresh images every 5 seconds (5000 milliseconds)
                        setInterval(function() {
                            refreshImages();
                        }, 2000); // Adjust the interval time as needed
                    }

                    // Call the function to fetch images at regular intervals
                    fetchImagesAtInterval();
                });
                function getDBdata(){
                    fetch('http://localhost:5000/project', {method: 'POST'})
                    .then(response => {
                        if (response.ok) {
                            console.log('got data from database');
                        } else {
                            console.error('Failed to get db data');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
                function addTask() {
                    var table = document.getElementById("taskTable");
                    var row = table.insertRow(-1);
                
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    var cell3 = row.insertCell(2);
                    var cell4 = row.insertCell(3);
                
                    cell1.innerHTML = '<input type="text" name="task">';
                    cell2.innerHTML = '<input type="number" name="duration">';
                    cell3.innerHTML = '<input type="text" name="dependencies">';
                    cell4.innerHTML = '<input type="text" name="description">';
                }
                function exportCSV() {
                    var table = document.getElementById("taskTable");
                    // var csvContent = "data:text/csv;charset=utf-8,TASK,DURATION,DEPENDENCIES\n";
                    var csvContent = "TASK,DURATION,DEPENDENCIES\n";

                    for (var i = 1; i < table.rows.length; i++) {
                        var row = table.rows[i];
                        var rowData = [];
                        for (var j = 0; j < row.cells.length - 1; j++) {
                            rowData.push(row.cells[j].querySelector('input').value);
                        }
                        csvContent += rowData.join(",") + "\n";
                    }

                    // Create a Blob object containing the CSV data
                    var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8' });
                     // Send the CSV data to the server-side PHP script for saving
                    fetch('save_csv.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ csvContent: csvContent })
                    })
                    .then(response => {
                        if (response.ok) {
                            console.log('CSV data sent successfully');
                        } else {
                            console.error('Failed to send CSV data');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });

                    // Send a request to trigger the Python script
                    fetch('http://localhost:5000/run_script', {method: 'POST'})                    
                        .then(response => {
                            
                            if (response.ok) {
                                console.log('Python script executed successfully');
                            } else {
                                console.error('Failed to execute Python script');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });

                }
                </script>

                <br><br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="chart-container">
                            <h2 style="text-align: center">PERT Chart</h2>
                            <div class="chart-wrapper">
                                <img id="pert" src="pert.png" alt="pert">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="chart-container">
                            <h2 style="text-align: center">Gantt Chart</h2>
                            <div class="chart-wrapper">
                                <img id="gantt" src="gantt.png" alt="gantt">
                            </div>
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
                        <!-- Welcome <?php echo $currentUser?> -->
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