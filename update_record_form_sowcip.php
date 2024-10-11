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
    select,
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
        <h1>Update Data into SOW CIP</h1>

        <form action="update_sow_cip.php" method="post">
            <?php

include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the SELECT query
    $sql = "SELECT * FROM sow_cip WHERE sow_cip_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<input type='hidden' name='id' value='" . $id . "'>";

            echo "PR No.: <input type='text' name='PR_No' value='" . $row["PR_No"] . "'><br>";
            echo "SOW No.: <input type='text' name='SOW_No' value='" . $row["SOW_No"] . "'><br>";
            echo "CIP Required: <input type='text' name='CIP_Required' value='" . $row["CIP_Required"] . "'><br>";
            echo "CIP No.: <input type='text' name='CIP_No' value='" . $row["CIP_No"] . "'><br>";
            echo "Electronic or Manual CIP: <input type='text' name='Electronic_or_Manual_CIP' value='" . $row["Electronic_or_Manual_CIP"] . "'><br>";
            echo "CIP Status: <input type='text' name='CIP_Status' value='" . $row["CIP_Status"] . "'><br>";
            echo "CIP Approval Date: <input type='text' name='CIP_Approved_Date' value='" . $row["CIP_Approved_Date"] . "'><br>";
            // BG Dropdown
            echo "BG: <select name='BG'>";
            $bg_list = ['Ace Digital', 'AHP', 'Averis', 'Bracell BSC', 'Bracell BSP', 'Bracell Offshore', 'Family Office', 'Forindo', 'Nova', 'Orionship', 'Pacific Energy', 'PEAM', 'Property', 'RGE', 'Tanoto Foundation', 'Woodchip'];
            foreach ($bg_list as $bg) {
                $selected = ($row["BG"] == $bg) ? 'selected' : '';
                echo "<option value='$bg' $selected>$bg</option>";
            }
            echo "</select><br>";
            echo "BU: <input type='text' name='BU' value='" . $row["BU"] . "'><br>";
            echo "Requestor: <input type='text' name='Requestor' value='" . $row["Requestor"] . "'><br>";
            echo "Project Manager Name: <input type='text' name='Project_Manager_Name' value='" . $row["Project_Manager_Name"] . "'><br>";
            echo "SOW Title: <input type='text' name='SOW_Title' value='" . $row["SOW_Title"] . "'><br>";
            echo "SOW Created Date: <input type='text' name='SOW_Created_Date' value='" . $row["SOW_Created_Date"] . "'><br>";
            echo "SOW Approved Date: <input type='text' name='SOW_Approved_Date' value='" . $row["SOW_Approved_Date"] . "'><br>";
            echo "SOW_Status: <input type='text' name='SOW_Status' value='" . $row["SOW_Status"] . "'><br>";
            echo "Alert: <input type='text' name='Alert' value='" . $row["Alert"] . "'><br>";
            echo "Total Cost: <input type='number' name='Total_Cost' value='" . $row["Total_Cost"] . "'><br>";
            echo "BGFC: <input type='text' name='BGFC' value='" . $row["BGFC"] . "'><br>";
            echo "Kick off Date: <input type='text' name='Kick_of_Date' value='" . $row["Kick_of_Date"] . "'><br>";
            echo "Go Live Date: <input type='text' name='Go_Live_Date' value='" . $row["Go_Live_Date"] . "'><br>";
            echo "Transition to Operation: <input type='text' name='Transition_to_Operation' value='" . $row["Transition_to_Operation"] . "'><br>";
            echo "Remark: <input type='text' name='Remark' value='" . $row["Remark"] . "'><br>";
            echo "Under Wai Yee: <input type='text' name='Under_WY' value='" . $row["Under_WY"] . "'><br>";
        }
    } else {
        echo "No results found.";
    }
}
?>
            <input type="submit" value="Update Data">
        </form>
    </div>
</body>

</html>