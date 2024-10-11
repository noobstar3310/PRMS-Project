<?php

include 'db_connect.php';

if (isset($_POST['id'])) {
    // Start transaction
    $conn->begin_transaction();

    try {
        // Retrieve the POST data
        $id = $_POST['id'];
        $BG = $_POST['BG'];
        $BU = $_POST['BU'];
        $Title = $_POST['Title'];
        $PR_No = $_POST['PR_No'];
        $SOW_No = $_POST['SOW_No'];
        $Requestor = $_POST['Requestor'];
        $Created_Date = $_POST['Created_Date'];
        $Working_Group = $_POST['Working_Group'];
        $Budgeted = $_POST['Budgeted'] === 'TRUE' ? 1 : 0;
        $Assigned_Staff = $_POST['Assigned_Staff'];
        $Benefits = $_POST['Benefits'];
        $Savings = $_POST['Savings'];
        $Risk = $_POST['Risk'];
        $Budget_Amo = $_POST['Budget_Amo'];
        $Scoping_Lead_Time = $_POST['Scoping_Lead_Time'];
        $Status = $_POST['Status'];
        $PMO_Status = $_POST['PMO_Status'];
        $Link = $_POST['Link'];
        $Total_CAPEX = $_POST['Total_CAPEX'];
        $Estimated_OPEX = $_POST['Estimated_OPEX'];
        $Remarks = $_POST['Remarks'];

        // Prepare the UPDATE query for pjr_sow
        $sql_pjr = "UPDATE pjr_sow SET
                BG = ?, BU = ?, Title = ?, PR_No = ?, SOW_No = ?,
                Requestor = ?, Created_Date = ?, Working_Group = ?,
                Budgeted = ?, Assigned_Staff = ?, Benefits = ?,
                Savings = ?, Risk = ?, Budget_Amo = ?,
                Scoping_Lead_Time = ?, Status = ?, PMO_Status = ?,
                Link = ?, `Total CAPEX (USD)` = ?, `Estimated OPEX (USD)` = ?,
                Remarks = ?
                WHERE pjr_sow_id = ?";

        $stmt_pjr = $conn->prepare($sql_pjr);
        if (!$stmt_pjr) {
            throw new Exception("Prepare failed for pjr_sow: " . $conn->error);
        }

        $stmt_pjr->bind_param("ssssssssssddddssssddsi", 
            $BG, $BU, $Title, $PR_No, $SOW_No, $Requestor, $Created_Date, 
            $Working_Group, $Budgeted, $Assigned_Staff, $Benefits, $Savings, 
            $Risk, $Budget_Amo, $Scoping_Lead_Time, $Status, $PMO_Status, 
            $Link, $Total_CAPEX, $Estimated_OPEX, $Remarks, $id);

        if (!$stmt_pjr->execute()) {
            throw new Exception("Execute failed for pjr_sow: " . $stmt_pjr->error);
        }

        // Update sow_cip table for linked fields
        $sql_sow_cip = "UPDATE sow_cip SET
                PR_No = ?, SOW_No = ?, BG = ?, BU = ?, Requestor = ?, SOW_Title = ?
                WHERE PR_No = ?";

        $stmt_sow_cip = $conn->prepare($sql_sow_cip);
        if (!$stmt_sow_cip) {
            throw new Exception("Prepare failed for sow_cip: " . $conn->error);
        }

        $stmt_sow_cip->bind_param("sssssss", 
            $PR_No, $SOW_No, $BG, $BU, $Requestor, $Title, $PR_No);

        if (!$stmt_sow_cip->execute()) {
            throw new Exception("Execute failed for sow_cip: " . $stmt_sow_cip->error);
        }

        // Commit the transaction
        $conn->commit();

        echo "Records updated successfully!";
        header("Location: pjr_sow_dashboard.php");
        exit();

    } catch (Exception $e) {
        // Rollback the transaction if an error occurs
        $conn->rollback();
        echo "Error updating records: " . $e->getMessage();
    } finally {
        // Close statements and connection
        if (isset($stmt_pjr)) $stmt_pjr->close();
        if (isset($stmt_sow_cip)) $stmt_sow_cip->close();
        $conn->close();
    }
} else {
    echo "No ID provided for update!";
}
?>