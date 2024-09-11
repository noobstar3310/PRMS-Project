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
                $PR_No = trim($sheetData[$row]['D']); // Fetch PR_No and trim whitespace

                // Skip processing if the PR_No is empty
                if (empty($PR_No)) {
                    continue;
                }

                // Fetch other values from the Excel row
                $BG = $sheetData[$row]['A'];
                $BU = $sheetData[$row]['B'];
                $Title = $sheetData[$row]['C'];
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

                // Check if PR_No already exists
                $check_sql = "SELECT * FROM pjr_sow WHERE PR_No = ?";
                $check_stmt = $conn->prepare($check_sql);
                $check_stmt->bind_param("s", $PR_No);
                $check_stmt->execute();
                $result = $check_stmt->get_result();

                if ($result->num_rows > 0) {
                    // If PR_No exists, update the record
                    $update_sql = "UPDATE pjr_sow SET 
                        BG = ?, BU = ?, Title = ?, SOW_No = ?, Requestor = ?, 
                        Created_Date = ?, Working_Group = ?, Budgeted = ?, 
                        Benefits = ?, Savings = ?, Risk = ?, Budget_Amo = ?, 
                        Scoping_Lead_Time = ?, Status = ?, PMO_Status = ?, 
                        `Total CAPEX (USD)` = ?, `Estimated OPEX (USD)` = ?, Remarks = ?
                        WHERE PR_No = ?";

                    $update_stmt = $conn->prepare($update_sql);
                    $update_stmt->bind_param("sssssssssssssssssss", $BG, $BU, $Title, $SOW_No, $Requestor, 
                        $Created_Date, $Working_Group, $Budgeted, $Benefits, $Savings, 
                        $Risk, $Budget_Amo, $Scoping_Lead_Time, $Status, $PMO_Status, 
                        $Total_CAPEX, $Estimated_OPEX, $Remarks, $PR_No);

                    if (!$update_stmt->execute()) {
                        echo "Error updating record: " . $update_stmt->error;
                    }
                } else {
                    // If PR_No doesn't exist, insert a new record
                    $insert_sql = "INSERT INTO pjr_sow (BG, BU, Title, PR_No, SOW_No, Requestor, Created_Date, Working_Group, Budgeted, Assigned_Staff, Benefits, Savings, Risk, Budget_Amo, Scoping_Lead_Time, Status, PMO_Status, Link, `Total CAPEX (USD)`, `Estimated OPEX (USD)`, Remarks)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                    $insert_stmt = $conn->prepare($insert_sql);
                    $insert_stmt->bind_param("ssssssssssssddddsssss", $BG, $BU, $Title, $PR_No, $SOW_No, $Requestor, $Created_Date, $Working_Group, $Budgeted, $Assigned_Staff, $Benefits, $Savings, $Risk, $Budget_Amo, $Scoping_Lead_Time, $Status, $PMO_Status, $Link, $Total_CAPEX, $Estimated_OPEX, $Remarks);

                    if (!$insert_stmt->execute()) {
                        echo "Error inserting record: " . $insert_stmt->error;
                    }
                }
            }

            echo "Records processed successfully!";
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