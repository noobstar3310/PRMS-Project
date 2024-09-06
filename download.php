<?php
$file = 'updated_file.xlsx'; // Path to the file you want to download

// Check if file exists
if (file_exists($file)) {
    // Set headers to prompt file download
    header('Content-Description: File Transfer');
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));

    // Read the file and output it
    readfile($file);
    exit;
} else {
    // Handle file not found
    echo 'File not found.';
}
?>