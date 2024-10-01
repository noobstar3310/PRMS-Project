<?php
require 'vendor/autoload.php'; // Include the Composer autoload file for PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $files = $_FILES['file'];

    // Create a new spreadsheet for the combined data
    $combinedSpreadsheet = new Spreadsheet();
    $combinedSheet = $combinedSpreadsheet->getActiveSheet();

    $isFirstFile = true; // Track whether it's the first file to include headers
    $nextRow = 1; // Start from the first row in the combined sheet

    // Loop through each uploaded file
    for ($i = 0; $i < count($files['tmp_name']); $i++) {
        // Skip if the file was not uploaded properly
        if ($files['error'][$i] !== UPLOAD_ERR_OK) {
            continue;
        }

        // Load the current spreadsheet
        $filePath = $files['tmp_name'][$i];
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        // If it's the first file, copy the header
        if ($isFirstFile) {
            $header = $sheet->rangeToArray('A1:' . $sheet->getHighestColumn() . '1');
            $combinedSheet->fromArray($header, NULL, 'A1');
            $isFirstFile = false; // Next files won't need the header
            $nextRow++;
        }

        // Copy the data from the current sheet (starting from the second row) to the combined sheet
        $data = $sheet->rangeToArray('A2:' . $sheet->getHighestColumn() . $sheet->getHighestRow());
        $combinedSheet->fromArray($data, NULL, 'A' . $nextRow);

        // Update the next row number for subsequent files
        $nextRow = $combinedSheet->getHighestRow() + 1;
    }

    // Set the filename for the combined file
    $filename = 'combined_file.xlsx';

    // Output the combined file to the browser for download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = IOFactory::createWriter($combinedSpreadsheet, 'Xlsx');
    $writer->save('php://output');
    exit();
} else {
    echo "Please upload at least one file.";
}
?>