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
                $PR_No = trim($sheetData[$row]['A']); // Fetch PR_No and trim whitespace

                // Skip processing if the PR_No is empty
                if (empty($PR_No)) {
                    continue;
                }

                // Fetch other values from the Excel row
                $SOW_No = $sheetData[$row]['B'];
                $CIP_Required = $sheetData[$row]['C'];
                $CIP_No = $sheetData[$row]['D'];
                $Electronic_or_Manual_CIP = $sheetData[$row]['E'];
                $CIP_Status = $sheetData[$row]['F'];
                $CIP_Approved_Date = $sheetData[$row]['G'];
                $BG = $sheetData[$row]['H'];
                $BU = $sheetData[$row]['I'];
                $Requestor = $sheetData[$row]['J'];
                $Project_Manager_Name = $sheetData[$row]['K'];
                $SOW_Title = $sheetData[$row]['L'];
                $SOW_Created_Date = $sheetData[$row]['M'];
                $SOW_Approved_Date = $sheetData[$row]['N'];
                $SOW_Status = $sheetData[$row]['O'];
                $Alert = $sheetData[$row]['P'];
                $Total_Cost = $sheetData[$row]['Q'];
                $BGFC = $sheetData[$row]['R'];
                $Kick_of_Date = $sheetData[$row]['S'];
                $Go_Live_Date = $sheetData[$row]['T'];
                $Transition_to_Operation = $sheetData[$row]['U'];
                $Remark = $sheetData[$row]['V'];
                $Under_WY = $sheetData[$row]['W'];

                // Check if PR_No already exists in sow_cip
                $check_sql = "SELECT * FROM sow_cip WHERE PR_No = ?";
                $check_stmt = $conn->prepare($check_sql);
                $check_stmt->bind_param("s", $PR_No);
                $check_stmt->execute();
                $result = $check_stmt->get_result();

                if ($result->num_rows > 0) {
                    // If PR_No exists, update the record
                    $update_sql = "UPDATE sow_cip SET 
                        SOW_No = ?, CIP_Required = ?, CIP_No = ?, Electronic_or_Manual_CIP = ?, 
                        CIP_Status = ?, CIP_Approved_Date = ?, BG = ?, BU = ?, Requestor = ?, 
                        Project_Manager_Name = ?, SOW_Title = ?, SOW_Created_Date = ?, 
                        SOW_Approved_Date = ?, SOW_Status = ?, Alert = ?, Total_Cost = ?, 
                        BGFC = ?, Kick_of_Date = ?, Go_Live_Date = ?, Transition_to_Operation = ?, 
                        Remark = ?, Under_WY = ?
                        WHERE PR_No = ?";

                    $update_stmt = $conn->prepare($update_sql);
                    $update_stmt->bind_param("sssssssssssssssssssssss", 
                        $SOW_No, $CIP_Required, $CIP_No, $Electronic_or_Manual_CIP, 
                        $CIP_Status, $CIP_Approved_Date, $BG, $BU, $Requestor, 
                        $Project_Manager_Name, $SOW_Title, $SOW_Created_Date, 
                        $SOW_Approved_Date, $SOW_Status, $Alert, $Total_Cost, 
                        $BGFC, $Kick_of_Date, $Go_Live_Date, $Transition_to_Operation, 
                        $Remark, $Under_WY, $PR_No);

                    if (!$update_stmt->execute()) {
                        echo "Error updating record in sow_cip: " . $update_stmt->error;
                    }
                } else {
                    // If PR_No doesn't exist, insert a new record
                    $insert_sql = "INSERT INTO sow_cip (PR_No, SOW_No, CIP_Required, CIP_No, Electronic_or_Manual_CIP, 
                        CIP_Status, CIP_Approved_Date, BG, BU, Requestor, Project_Manager_Name, SOW_Title, 
                        SOW_Created_Date, SOW_Approved_Date, SOW_Status, Alert, Total_Cost, BGFC, Kick_of_Date, 
                        Go_Live_Date, Transition_to_Operation, Remark, Under_WY)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                    $insert_stmt = $conn->prepare($insert_sql);
                    $insert_stmt->bind_param("ssssssssssssssssdssssss", 
                        $PR_No, $SOW_No, $CIP_Required, $CIP_No, $Electronic_or_Manual_CIP, 
                        $CIP_Status, $CIP_Approved_Date, $BG, $BU, $Requestor, $Project_Manager_Name, $SOW_Title, 
                        $SOW_Created_Date, $SOW_Approved_Date, $SOW_Status, $Alert, $Total_Cost, $BGFC, $Kick_of_Date, 
                        $Go_Live_Date, $Transition_to_Operation, $Remark, $Under_WY);

                    if (!$insert_stmt->execute()) {
                        echo "Error inserting record into sow_cip: " . $insert_stmt->error;
                    }
                }

                // Update linked fields in pjr_sow table
                $update_pjr_sql = "UPDATE pjr_sow SET 
                    SOW_No = ?, BG = ?, BU = ?, Requestor = ?, Title = ?
                    WHERE PR_No = ?";

                $update_pjr_stmt = $conn->prepare($update_pjr_sql);
                $update_pjr_stmt->bind_param("ssssss", 
                    $SOW_No, $BG, $BU, $Requestor, $SOW_Title, $PR_No);

                if (!$update_pjr_stmt->execute()) {
                    echo "Error updating linked fields in pjr_sow: " . $update_pjr_stmt->error;
                }
            }

            echo "Records processed successfully!";
            header("Location: sow_cip_dashboard.php");
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