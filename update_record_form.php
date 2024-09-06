<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Data into PJR-SOW</title>
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
        <h1>Update Data into PJR-SOW</h1>

        <form action="update_record.php" method="post">
<?php

include 'db_connect.php';

if (isset($_GET['id']))
{
    $id = $_GET['id'];

    // Prepare and execute the SELECT query
    $sql = "SELECT * FROM pjr_sow WHERE pjr_sow_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    if ($result->num_rows > 0)
    {
        while ($row = $result->fetch_assoc())
        {
            echo "<input type='hidden' name='id' value='" . $id . "'>";
            echo "BG: <input type='text' name='BG' value='" . $row["BG"] . "'><br>";
            echo "BU: <input type='text' name='BU' value='" . $row["BU"] . "'><br>";
            echo "Title: <input type='text' name='Title' value='" . $row["Title"] . "'><br>";
            echo "PR No.: <input type='text' name='PR_No' value='" . $row["PR_No"] . "'><br>";
            echo "SOW No.: <input type='text' name='SOW_No' value='" . $row["SOW_No"] . "'><br>";
            echo "Requestor: <input type='text' name='Requestor' value='" . $row["Requestor"] . "'><br>";
            echo "Created Date: <input type='text' name='Created_Date' value='" . $row["Created_Date"] . "'><br>";
            echo "Working Group: <input type='text' name='Working_Group' value='" . $row["Working_Group"] . "'><br>";
            echo "Budgeted: <input type='text' name='Budgeted' value='" . $row["Budgeted"] . "'><br>";
            echo "Assigned Staff: <input type='text' name='Assigned_Staff' value='" . $row["Assigned_Staff"] . "'><br>";
            echo "Benefits: <input type='number' step='0.01' name='Benefits' value='" . $row["Benefits"] . "'><br>";
            echo "Savings: <input type='number' step='0.01' name='Savings' value='" . $row["Savings"] . "'><br>";
            echo "Risk: <input type='number' step='0.01' name='Risk' value='" . $row["Risk"] . "'><br>";
            echo "Budget Amo: <input type='number' step='0.01' name='Budget_Amo' value='" . $row["Budget_Amo"] . "'><br>";
            echo "Scoping Lead Time: <input type='text' name='Scoping_Lead_Time' value='" . $row["Scoping_Lead_Time"] . "'><br>";
            echo "Status: <input type='text' name='Status' value='" . $row["Status"] . "'><br>";
            echo "PMO Status: <input type='text' name='PMO_Status' value='" . $row["PMO_Status"] . "'><br>";
            echo "Link: <input type='url' name='Link' value='" . $row["Link"] . "'><br>";
            echo "Total CAPEX (USD): <input type='number' step='0.01' name='Total_CAPEX' value='" . $row["Total CAPEX (USD)"] . "'><br>";
            echo "Estimated OPEX (USD): <input type='number' step='0.01' name='Estimated_OPEX' value='" . $row["Estimated OPEX (USD)"] . "'><br>";
            echo "Remarks: <textarea name='Remarks'>" . $row["Remarks"] . "</textarea><br>";
        }
    }
    else
    {
        echo "No results found.";
    }
}
?>
            <input type="submit" value="Update Data">
        </form>
    </div>
</body>
</html>