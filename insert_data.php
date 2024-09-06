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
        form {
            display: flex;
            flex-direction: column;
        }
        input[type=text],
        input[type=number],
        input[type=date],
        input[type=url],
        textarea {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        input[type=submit] {
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background-color: #4cae4c;
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

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO `pjr_sow` (
                        BG, BU, Title, PR_No, SOW_No, 
                        Requestor, Created_Date, Working_Group, Budgeted, Assigned_Staff, Benefits, Savings, 
                        Risk, Budget_Amo, Scoping_Lead_Time, Status, PMO_Status, Link
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssddddssss", $BG, $BU, $Title, $PR_No, $SOW_No, $Requestor, $Created_Date, $Working_Group, $Budgeted, $Assigned_Staff, $Benefits, $Savings, $Risk, $Budget_Amo, $Scoping_Lead_Time, $Status, $PMO_Status, $Link);

// Set parameters and execute
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


if ($stmt->execute())
{
    echo "New records created successfully";
    header("Location: pjr_sow_dashboard.php");
        exit();
}
else
{
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
    </div>
</body>
</html>
