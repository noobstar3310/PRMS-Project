<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Records via Excel</title>
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

    .button {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        margin: 10px 0;
        width: 100%;
        box-sizing: border-box;
    }

    .button:hover {
        background-color: #0056b3;
    }

    .danger-button {
        background-color: #d9534f;
    }

    .danger-button:hover {
        background-color: #c9302c;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Update Records via Excel</h1>
        <form action="process_update_via_excel.php" method="post" enctype="multipart/form-data">
            <input type="file" name="excelFile" id="fileInput" accept=".xls,.xlsx" required>
            <button type="submit" class="button">Upload and Update Records</button>
            <button type="button" onclick="window.location.href = 'pjr_sow_dashboard.php'"
                class="button danger-button">Cancel</button>
        </form>
    </div>
</body>

</html>