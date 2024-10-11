<?php

include 'db_connect.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['id'])) {
    // Retrieve the POST data for SOW CIP fields
    $id = $_POST['id'];
    $PR_No = $_POST['PR_No'];
    $SOW_No = $_POST['SOW_No'];
    $CIP_Required = $_POST['CIP_Required'];
    $CIP_No = $_POST['CIP_No'];
    $Electronic_or_Manual_CIP = $_POST['Electronic_or_Manual_CIP'];
    $CIP_Status = $_POST['CIP_Status'];
    $CIP_Approved_Date = $_POST['CIP_Approved_Date'];
    $BG = $_POST['BG'];
    $BU = $_POST['BU'];
    $Requestor = $_POST['Requestor'];
    $Project_Manager_Name = $_POST['Project_Manager_Name'];
    $SOW_Title = $_POST['SOW_Title'];
    $SOW_Created_Date = $_POST['SOW_Created_Date'];
    $SOW_Approved_Date = $_POST['SOW_Approved_Date'];
    $SOW_Status = $_POST['SOW_Status'];
    $Alert = $_POST['Alert'];
    $Total_Cost = $_POST['Total_Cost'];
    $BGFC = $_POST['BGFC'];
    $Kick_of_Date = $_POST['Kick_of_Date'];
    $Go_Live_Date = $_POST['Go_Live_Date'];
    $Transition_to_Operation = $_POST['Transition_to_Operation'];
    $Remark = $_POST['Remark'];
    $Under_WY = $_POST['Under_WY'];

    // Prepare the UPDATE query for the sow_cip table
    $sql = "UPDATE sow_cip SET
            PR_No = ?, SOW_No = ?, CIP_Required = ?, CIP_No = ?, 
            Electronic_or_Manual_CIP = ?, CIP_Status = ?, CIP_Approved_Date = ?, 
            BG = ?, BU = ?, Requestor = ?, Project_Manager_Name = ?, 
            SOW_Title = ?, SOW_Created_Date = ?, SOW_Approved_Date = ?, 
            SOW_Status = ?, Alert = ?, Total_Cost = ?, BGFC = ?, 
            Kick_of_Date = ?, Go_Live_Date = ?, Transition_to_Operation = ?, 
            Remark = ?, Under_WY = ?
            WHERE sow_cip_id = ?";

    // UPDATE query for the pjr_sow table
    $sql_pjr = "UPDATE pjr_sow SET
            PR_No = ?, SOW_No = ?, BG = ?, BU = ?, Requestor = ?
            WHERE PR_No = ?";

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Update pjr_sow table first
        $stmt_pjr = $conn->prepare($sql_pjr);
        if (!$stmt_pjr) {
            throw new Exception("Prepare failed for pjr_sow: (" . $conn->errno . ") " . $conn->error);
        }

        $bind_result_pjr = $stmt_pjr->bind_param("ssssss", $PR_No, $SOW_No, $BG, $BU, $Requestor, $PR_No);
        if (!$bind_result_pjr) {
            throw new Exception("Binding parameters failed for pjr_sow: (" . $stmt_pjr->errno . ") " . $stmt_pjr->error);
        }

        $execute_result_pjr = $stmt_pjr->execute();
        if (!$execute_result_pjr) {
            throw new Exception("Execute failed for pjr_sow: (" . $stmt_pjr->errno . ") " . $stmt_pjr->error);
        }

        echo "Rows affected in pjr_sow: " . $stmt_pjr->affected_rows . "<br>";

        // Now update sow_cip table
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        
        $bind_result = $stmt->bind_param(
            "ssssssssssssssssissssssi",
            $PR_No, $SOW_No, $CIP_Required, $CIP_No, $Electronic_or_Manual_CIP,
            $CIP_Status, $CIP_Approved_Date, $BG, $BU, $Requestor,
            $Project_Manager_Name, $SOW_Title, $SOW_Created_Date, $SOW_Approved_Date,
            $SOW_Status, $Alert, $Total_Cost, $BGFC, $Kick_of_Date,
            $Go_Live_Date, $Transition_to_Operation, $Remark, $Under_WY, $id
        );
        if (!$bind_result) {
            throw new Exception("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        $execute_result = $stmt->execute();
        if (!$execute_result) {
            throw new Exception("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        echo "Rows affected in sow_cip: " . $stmt->affected_rows . "<br>";

        // Commit the transaction
        $conn->commit();

        echo "Records updated successfully!";
        // Uncomment the following line when you're ready to redirect
        header("Location: sow_cip_dashboard.php");
        exit();
        
    } catch (Exception $e) {
        // Rollback the transaction if an error occurs
        $conn->rollback();
        echo "Error updating records: " . $e->getMessage();
    }

    if (isset($stmt_pjr)) $stmt_pjr->close();
    if (isset($stmt)) $stmt->close();
    $conn->close();
} else {
    echo "No ID provided for update!";
}

?>