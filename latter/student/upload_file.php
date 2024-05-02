<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if file was uploaded without errors
    if (isset($_FILES["filename"]) && $_FILES["filename"]["error"] == 0) {
        $upload_dir = "uploads/"; // Directory where the file will be saved
        $file_name = basename($_FILES["filename"]["name"]);
        $target_path = $upload_dir . $file_name;

        // Check if file already exists
        if (file_exists($target_path)) {
            // If file exists, delete it
            unlink($target_path);
        }

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES["filename"]["tmp_name"], $target_path)) {
            echo "The file " . $file_name . " has been uploaded.";

            // Display the contents of the uploaded file
            echo "<h2 style=\"color:black;\">File Contents:</h2>";
            echo "<pre style=\"color:black;\">";
            echo htmlspecialchars(file_get_contents($target_path));
            echo "</pre>";

            // Execute the Python script
            // exec('python pert_app.py');
            $response = file_get_contents("http://localhost:5000/run_test_code?filename=" . urlencode($file_name));
            $response = file_get_contents("http://localhost:5000/run_exe?filename=" . urlencode($file_name));

//             // Send the response back to the client
            echo $response;

            // Check if the output file exists
            $output_file = "output.txt";
            if (file_exists($output_file)) {
                // Display the contents of the output file
                echo "<h2 style=\"color:black;\">Output:</h2>";
                echo "<pre style=\"color:black;\">";
                echo htmlspecialchars(file_get_contents($output_file));
                echo "</pre>";
            } else {
                echo "<div style='color: red;'>Error: Output file not found</div>";
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Error: " . $_FILES["filename"]["error"];
    }
}



// // Check if the form was submitted
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Check if file was uploaded without errors
//     if (isset($_FILES["filename"]) && $_FILES["filename"]["error"] == 0) {
//         $upload_dir = "uploads/"; // Directory where the file will be saved
//         $file_name = basename($_FILES["filename"]["name"]);
//         $target_path = $upload_dir . $file_name;

//         // Check if file already exists
//         if (file_exists($target_path)) {
//             // If file exists, delete it
//             unlink($target_path);
//         }

//         // Move the uploaded file to the specified directory
//         if (move_uploaded_file($_FILES["filename"]["tmp_name"], $target_path)) {
//             echo "The file " . $file_name . " has been uploaded.";

//             // Display the contents of the uploaded file
//             echo "<h2>File Contents:</h2>";
//             echo "<pre>";
//             echo htmlspecialchars(file_get_contents($target_path));
//             echo "</pre>";

//             // Assuming your Python Flask application is running on localhost:5000
//             $response = file_get_contents("http://localhost:5000/run_test_code?filename=" . urlencode($file_name));

//             // Send the response back to the client
//             echo $response;
//         } else {
//             echo "Sorry, there was an error uploading your file.";
//         }
//     } else {
//         echo "Error: " . $_FILES["filename"]["error"];
//     }
// }
