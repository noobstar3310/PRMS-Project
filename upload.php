<?php
require 'vendor/autoload.php'; // Include the Composer autoload file for PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file1']) && isset($_FILES['file2'])) {
    $file1 = $_FILES['file1']['tmp_name'];
    $file2 = $_FILES['file2']['tmp_name'];

    // Load the first spreadsheet
    $spreadsheet1 = IOFactory::load($file1);
    $sheet1 = $spreadsheet1->getActiveSheet();

    // Load the second spreadsheet
    $spreadsheet2 = IOFactory::load($file2);
    $sheet2 = $spreadsheet2->getActiveSheet();

    // Create a new spreadsheet for the combined data
    $combinedSpreadsheet = new Spreadsheet();
    $combinedSheet = $combinedSpreadsheet->getActiveSheet();

    // Copy the header from the first sheet to the combined sheet
    $header = $sheet1->rangeToArray('A1:' . $sheet1->getHighestColumn() . '1');
    $combinedSheet->fromArray($header, NULL, 'A1');

    // Copy the data from the first sheet (starting from the second row) to the combined sheet
    $data1 = $sheet1->rangeToArray('A2:' . $sheet1->getHighestColumn() . $sheet1->getHighestRow());
    $combinedSheet->fromArray($data1, NULL, 'A2');

    // Find the next empty row in the combined sheet
    $nextRow = $combinedSheet->getHighestRow() + 1;

    // Copy the data from the second sheet (starting from the second row) to the combined sheet
    $data2 = $sheet2->rangeToArray('A2:' . $sheet2->getHighestColumn() . $sheet2->getHighestRow());
    $combinedSheet->fromArray($data2, NULL, 'A' . $nextRow);

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
    echo "Please upload both files.";
}
?>