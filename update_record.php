<?php

include 'db_connect.php';

if (isset($_POST['id'])) {

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
    $Budgeted = $_POST['Budgeted'] === 'TRUE' ? 1 : 0; // Convert TRUE/FALSE to 1/0
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

    // Prepare the UPDATE query with new columns
    $sql = "UPDATE pjr_sow SET
            BG = ?,
            BU = ?,
            Title = ?,
            PR_No = ?,
            SOW_No = ?,
            Requestor = ?,
            Created_Date = ?,
            Working_Group = ?,
            Budgeted = ?,
            Assigned_Staff = ?,
            Benefits = ?,
            Savings = ?,
            Risk = ?,
            Budget_Amo = ?,
            Scoping_Lead_Time = ?,
            Status = ?,
            PMO_Status = ?,
            Link = ?,
            `Total CAPEX (USD)` = ?,
            `Estimated OPEX (USD)` = ?,
            Remarks = ?
            WHERE pjr_sow_id = ?";

    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("ssssssssssddddssssddsi", $BG, $BU, $Title, $PR_No, $SOW_No,
            $Requestor, $Created_Date, $Working_Group, $Budgeted, $Assigned_Staff, $Benefits,
            $Savings, $Risk, $Budget_Amo, $Scoping_Lead_Time, $Status, $PMO_Status, $Link,
            $Total_CAPEX, $Estimated_OPEX, $Remarks, $id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Records updated successfully!";
        header("Location: pjr_sow_dashboard.php");
        exit();
    } else {
        echo "Error updating records: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Nothing is being passed!";
}
?>


