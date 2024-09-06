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

    .button {
        padding: 10px 20px;
        background-color: #5cb85c;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        margin: 10px 0;
        width: 100%;
        /* Set button width to 100% of the container */
        box-sizing: border-box;
        /* Include padding and border in the element's total width */
    }

    .button:hover {
        background-color: #4cae4c;
    }

    .secondary-button {
        background-color: #007bff;
    }

    .secondary-button:hover {
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
        <button id="uploadButton" class="button secondary-button">Upload Excel File</button>
        <div id="fileUploadDialog" style="display:none;">
            <form id="uploadForm" action="add_record.php" method="post" enctype="multipart/form-data">
                <input type="file" name="excelFile" id="fileInput" accept=".xls,.xlsx">
                <button type="submit" class="button secondary-button">Upload</button>
                <button type="button" id="cancelButton" class="button danger-button">Cancel</button>
            </form>
        </div>
    </div>

    <div class="container">
        <form action="add_record_form.php" method="post">
            <!-- Your form fields go here -->
            <button type="button" onclick="window.location.href = 'add_record_form.php'"
                class="button secondary-button">Add Record</button>
        </form>
    </div>

    <script>
    // handle button to pop up
    document.addEventListener('DOMContentLoaded', function() {
        const uploadButton = document.getElementById('uploadButton');
        const fileUploadDialog = document.getElementById('fileUploadDialog');
        const cancelButton = document.getElementById('cancelButton');

        uploadButton.addEventListener('click', function() {
            fileUploadDialog.style.display = 'block';
        });

        cancelButton.addEventListener('click', function() {
            fileUploadDialog.style.display = 'none';
            document.getElementById('fileInput').value = ''; // Clear file input
        });
    });
    </script>
</body>

</html>