<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Upload Files</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        max-width: 400px;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    }

    h1 {
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }

    form {
        display: flex;
        flex-direction: column;
    }

    label {
        margin-bottom: 10px;
        font-weight: bold;
    }

    input[type="file"] {
        margin-bottom: 15px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        cursor: pointer;
    }

    input[type="submit"] {
        padding: 10px;
        background-color: #5cb85c;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    input[type="submit"]:hover {
        background-color: #4cae4c;
    }

    button {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        margin: 10px 0;
    }

    button:hover {
        background-color: #0056b3;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Upload Files</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data" id="uploadForm">
            <div id="fileInputs">
                <label for="file1">Select new file:</label>
                <input type="file" name="file[]" id="file1"><br>
                <label for="file2">Select file to append:</label>
                <input type="file" name="file[]" id="file2"><br>
            </div>
            <button type="button" onclick="addFileInput()">Add More File</button>
            <input type="submit" value="Upload Files" name="submit">
            <button type="button" onclick="window.location.href = 'pjr_sow_dashboard.php'">Back</button>
        </form>
    </div>

    <script>
    let fileCount = 3;

    function addFileInput() {
        // Create a new div to hold the new input
        const newFileDiv = document.createElement("div");

        // Create the label for the new file input
        const newLabel = document.createElement("label");
        newLabel.setAttribute("for", `file${fileCount}`);
        newLabel.textContent = `Select additional file ${fileCount}:`;

        // Create the new file input
        const newFileInput = document.createElement("input");
        newFileInput.type = "file";
        newFileInput.name = "file[]";
        newFileInput.id = `file${fileCount}`;

        // Add a line break for spacing
        const lineBreak = document.createElement("br");

        // Append the label, input, and line break to the new div
        newFileDiv.appendChild(newLabel);
        newFileDiv.appendChild(newFileInput);
        newFileDiv.appendChild(lineBreak);

        // Append the new div to the fileInputs container
        document.getElementById("fileInputs").appendChild(newFileDiv);

        // Increment the file count for unique IDs
        fileCount++;
    }
    </script>
</body>

</html>