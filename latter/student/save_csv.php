<?php

// Create a temporary directory for storing CSV files if it doesn't exist
$tempDir = 'temp_csv';
if (!file_exists($tempDir)) {
    mkdir($tempDir, 0777, true); // Adjust permissions as needed
}

// Generate a unique filename for the CSV file
$csvFilename = 'temp_csv/tasks.csv';

// Get the CSV data from the request
$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody, true);
$csvContent = $data['csvContent'];

// Save the CSV content to the temporary file
file_put_contents($csvFilename, $csvContent);

// Respond with the path to the saved CSV file
echo $csvFilename;
