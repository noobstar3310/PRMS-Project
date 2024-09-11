<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Insert Data into PJR-SOW</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 600px;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        color: #333;
        text-align: center;
    }

    .alert {
        color: #ff0000;
        font-weight: bold;
        text-align: center;
    }
    </style>
</head>

<body>
    <div class="container">

        <?php

// Database connection variables
$servername = "localhost";
$username = "root";
$password = "adminpassword";
$dbname = "testdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the form data
$BG = $_POST['BG'];
$BU = $_POST['BU'];
$Title = $_POST['Title'];
$PR_No = $_POST['PR_No'];
$SOW_No = $_POST['SOW_No'];
$Requestor = $_POST['Requestor'];
$Created_Date = $_POST['Created_Date'];
$Working_Group = $_POST['Working_Group'];
$Budgeted = $_POST['Budgeted'];
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

// Check for duplicate PR_No
$checkSql = "SELECT * FROM `pjr_sow` WHERE `PR_No` = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("s", $PR_No);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    // Duplicate PR_No found
    echo "<div class='alert'>Error: The PR No '$PR_No' already exists. Redirecting back to the dashboard...</div>";
    echo "<script>
        alert('Error: The PR No \"$PR_No\" already exists.');
        window.location.href = 'pjr_sow_dashboard.php';
    </script>";
} else {
    // Prepare and bind for inserting new record
    $stmt = $conn->prepare("INSERT INTO `pjr_sow` (
                            BG, BU, Title, PR_No, SOW_No, Requestor, Created_Date, 
                            Working_Group, Budgeted, Assigned_Staff, Benefits, Savings, 
                            Risk, Budget_Amo, Scoping_Lead_Time, Status, PMO_Status, Link,
                            `Total CAPEX (USD)`, `Estimated OPEX (USD)`, Remarks
                        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssddddssssdds", $BG, $BU, $Title, $PR_No, $SOW_No, $Requestor, 
                    $Created_Date, $Working_Group, $Budgeted, $Assigned_Staff, $Benefits, 
                    $Savings, $Risk, $Budget_Amo, $Scoping_Lead_Time, $Status, $PMO_Status, 
                    $Link, $Total_CAPEX, $Estimated_OPEX, $Remarks);

    if ($stmt->execute()) {
        echo "New record created successfully";
        header("Location: pjr_sow_dashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$checkStmt->close();
$conn->close();
?>
    </div>
</body>

</html>