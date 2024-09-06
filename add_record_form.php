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
            <h1>Insert Data into PJR-SOW</h1>

            <form action="insert_data.php" method="post">

                <input type="hidden" name="pjr_sow_id" value=""> <!-- Assuming this is auto-incremented -->
                BG: <input type="text" name="BG"><br>
                BU: <input type="text" name="BU"><br>
                Title: <input type="text" name="Title"><br>
                PR_No: <input type="text" name="PR_No"><br>
                SOW_No: <input type="text" name="SOW_No"><br>
                Requestor: <input type="text" name="Requestor"><br>
                Created_Date: <input type="date" name="Created_Date"><br>
                Working_Group: <input type="text" name="Working_Group"><br>
                Budgeted: <input type="text" name="Budgeted"><br>
                Assigned_Staff: <input type"text" name="Assigned_Staff"><br>
                Benefits: <input type="number" step="0.01" name="Benefits"><br>
                Savings: <input type="number" step="0.01" name="Savings"><br>
                Risk: <input type=number step=0.01 name=Risk><br>
                Budget_Amo: <input type=number step=0.01 name="Budget_Amo"><br>
                Scoping_Lead_Time: <input type=text name=Scoping_Lead_Time><br>
                Status: <input type=text name=Status><br>
                PMO_Status: <input type=text name=PMO_Status><br>
                Link: <input type=url name=Link><br>


                <input type="submit" value="Insert Data">
            </form>
        </div>
    </body>
</html>
