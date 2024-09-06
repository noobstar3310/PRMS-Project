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
                $BG = $sheetData[$row]['A'];
                $BU = $sheetData[$row]['B'];
                $Title = $sheetData[$row]['C'];
                $PR_No = $sheetData[$row]['D'];
                $SOW_No = $sheetData[$row]['E'];
                $Requestor = $sheetData[$row]['F'];
                $Created_Date = $sheetData[$row]['G'];
                $Working_Group = $sheetData[$row]['H'];
                $Budgeted = $sheetData[$row]['I']; // Treating as string (TRUE/FALSE)
                $Assigned_Staff = ''; // Auto blank when inserting record
                $Benefits = $sheetData[$row]['J'];
                $Savings = $sheetData[$row]['K'];
                $Risk = $sheetData[$row]['L'];
                $Budget_Amo = $sheetData[$row]['M'];
                $Scoping_Lead_Time = $sheetData[$row]['N'];
                $Status = $sheetData[$row]['O'];

                // Set remaining fields to NULL
                $PMO_Status = NULL;
                $Link = NULL;
                $Total_CAPEX = NULL;
                $Estimated_OPEX = NULL;
                $Remarks = NULL;

                // Prepare the SQL INSERT statement
                $sql = "INSERT INTO pjr_sow (BG, BU, Title, PR_No, SOW_No, Requestor, Created_Date, Working_Group, Budgeted, Assigned_Staff, Benefits, Savings, Risk, Budget_Amo, Scoping_Lead_Time, Status, PMO_Status, Link, `Total CAPEX (USD)`, `Estimated OPEX (USD)`, Remarks)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssssssssssddddsssss", $BG, $BU, $Title, $PR_No, $SOW_No, $Requestor, $Created_Date, $Working_Group, $Budgeted, $Assigned_Staff, $Benefits, $Savings, $Risk, $Budget_Amo, $Scoping_Lead_Time, $Status, $PMO_Status, $Link, $Total_CAPEX, $Estimated_OPEX, $Remarks);

                if (!$stmt->execute()) {
                    echo "Error inserting record: " . $stmt->error;
                }
            }

            echo "Records added successfully!";
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

