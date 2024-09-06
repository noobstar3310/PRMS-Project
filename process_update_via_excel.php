<?php
require 'vendor/autoload.php'; // Include the Composer autoload file for PHPExcel

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['excelFile'])) {
    $fileName = $_FILES['excelFile']['tmp_name'];

    // Check if the file is a valid Excel file
    if ($_FILES['excelFile']['error'] === UPLOAD_ERR_OK && is_uploaded_file($fileName)) {
        try {
            // Load the Excel file
            $spreadsheet = IOFactory::load($fileName);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            // Start from the second row (skip the header)
            for ($row = 2; $row <= count($sheetData); $row++) {
                $PR_No = $sheetData[$row]['D']; // Column where PR No is stored

                // Check if PR_No exists in the table
                $sqlCheck = "SELECT * FROM pjr_sow WHERE PR_No = ?";
                $stmtCheck = $conn->prepare($sqlCheck);
                $stmtCheck->bind_param("s", $PR_No);
                $stmtCheck->execute();
                $resultCheck = $stmtCheck->get_result();

                if ($resultCheck->num_rows > 0) {
                    // Record found, update it
                    $BG = $sheetData[$row]['A'];
                    $BU = $sheetData[$row]['B'];
                    $Title = $sheetData[$row]['C'];
                    $SOW_No = $sheetData[$row]['E'];
                    $Requestor = $sheetData[$row]['F'];
                    $Created_Date = $sheetData[$row]['G'];
                    $Working_Group = $sheetData[$row]['H'];
                    $Budgeted = $sheetData[$row]['I']; 
                    $Assigned_Staff = ''; // Auto blank when updating record
                    $Benefits = $sheetData[$row]['J'];
                    $Savings = $sheetData[$row]['K'];
                    $Risk = $sheetData[$row]['L'];
                    $Budget_Amo = $sheetData[$row]['M'];
                    $Scoping_Lead_Time = $sheetData[$row]['N'];
                    $Status = $sheetData[$row]['O'];

                    // Prepare the SQL UPDATE statement
                    $sqlUpdate = "UPDATE pjr_sow SET 
                        BG = ?, BU = ?, Title = ?, SOW_No = ?, Requestor = ?, Created_Date = ?, 
                        Working_Group = ?, Budgeted = ?, Assigned_Staff = ?, Benefits = ?, 
                        Savings = ?, Risk = ?, Budget_Amo = ?, Scoping_Lead_Time = ?, Status = ? 
                        WHERE PR_No = ?";

                    $stmtUpdate = $conn->prepare($sqlUpdate);
                    $stmtUpdate->bind_param("ssssssssssddddss", $BG, $BU, $Title, $SOW_No, $Requestor, 
                        $Created_Date, $Working_Group, $Budgeted, $Assigned_Staff, $Benefits, 
                        $Savings, $Risk, $Budget_Amo, $Scoping_Lead_Time, $Status, $PR_No);

                    if (!$stmtUpdate->execute()) {
                        echo "Error updating record for PR No: " . $PR_No . " - " . $stmtUpdate->error;
                    }
                }
            }

            echo "Records updated successfully!";
            header("Location: pjr_sow_dashboard.php");
            exit();

        } catch (Exception $e) {
            echo "Error loading Excel file: " . $e->getMessage();
        }
    } else {
        echo "Error uploading file.";
    }
} else {
    echo "No file uploaded.";
}
?>