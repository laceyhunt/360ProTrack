<?php 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    echo '<p> This is from the php script </p>';
    echo '<p> ' .$_POST['projectName'] . ' </p>';
    // echo '<p class="text-primary"> No instructor collaborators. </p>'
    // Check if projectName is set in $_POST
    if(isset($_POST['projectName'])) {
        // Get the project name from $_POST
        $_SESSION['projectName'] = $_POST['projectName'];
        // $projectName=$_POST['projectName'];
        // Send a success response back to the client
        echo 'Project name updated successfully.';
    } else {
        // Send an error response back to the client
        http_response_code(400); // Bad Request
        echo 'Error: Project name not provided.';
    }
    
    // $projectName = isset($_SESSION['projectName']) ? $_SESSION['projectName'] : "Default Project Name";
    echo 'Redirecting to student_home.php?variable_name=' . urlencode($projectName);
    header("Location: student_home.php?variable_name=". urlencode($projectName));
    echo "name from update_project_name.php is: ";
    echo $projectName;