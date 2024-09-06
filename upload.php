<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File Upload Results</title>
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
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        p {
            color: #333;
            margin: 10px 0;
        }
        .success {
            color: #5cb85c;
            font-weight: bold;
        }
        .error {
            color: #d9534f;
            font-weight: bold;
        }
        a {
            color: #5cb85c;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>File Upload Results</h1>
        <?php
        require 'vendor/autoload.php';

        use PhpOffice\PhpSpreadsheet\IOFactory;
        use PhpOffice\PhpSpreadsheet\Spreadsheet;
        use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

        if (isset($_FILES['file1']) && isset($_FILES['file2'])) {
            // Check for upload errors
            if ($_FILES['file1']['error'] === UPLOAD_ERR_OK && $_FILES['file2']['error'] === UPLOAD_ERR_OK) {
                $file1Path = $_FILES['file1']['tmp_name'];
                $file2Path = $_FILES['file2']['tmp_name'];

                // Debugging: Print file paths
                echo "<p>File1 path: $file1Path</p>";
                echo "<p>File2 path: $file2Path</p>";

                // Check if files exist
                if (file_exists($file1Path) && file_exists($file2Path)) {
                    try {
                        // Load the first Excel file
                        $spreadsheet1 = IOFactory::load($file1Path);
                        $worksheet1 = $spreadsheet1->getActiveSheet();
                        $data1 = $worksheet1->toArray();

                        // Load the second Excel file
                        $spreadsheet2 = IOFactory::load($file2Path);
                        $worksheet2 = $spreadsheet2->getActiveSheet();

                        // Define column mapping from first file to second file
                        $columnMapping = [
                            'A' => 'C', // Map column A in file1 to column A in file2
                            'B' => 'D',
                            'C' => 'B',
                            // Add more mappings as needed
                        ];

                        // Find the next empty row in the second file
                        $highestRow = $worksheet2->getHighestRow();

                        // Append data from the first file to the second file using the column mapping
                        foreach ($data1 as $rowIndex => $row) {
                            $highestRow++;
                            foreach ($columnMapping as $file1Col => $file2Col) {
                                $file1ColIndex = Coordinate::columnIndexFromString($file1Col);
                                $file2ColIndex = Coordinate::columnIndexFromString($file2Col);
                                $worksheet2->setCellValue([$file2ColIndex, $highestRow], $row[$file1ColIndex - 1]);
                            }
                        }

                        // Save the updated second file
                        $outputFileName = 'updated_file.xlsx';
                        $writer = IOFactory::createWriter($spreadsheet2, 'Xlsx');
                        $writer->save($outputFileName);

                        echo "<p class='success'>Files processed successfully. The updated file is saved as '<a href='download.php?file=$outputFileName'>updated_file.xlsx</a>'.</p>";
                    } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                        echo "<p class='error'>Error loading file: " . $e->getMessage() . "</p>";
                    } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
                        echo "<p class='error'>Spreadsheet error: " . $e->getMessage() . "</p>";
                    }
                } else {
                    echo "<p class='error'>Error: One or both files do not exist after upload.</p>";
                    echo "<p>File1 path: $file1Path</p>";
                    echo "<p>File2 path: $file2Path</p>";
                }
            } else {
                // Handle file upload errors
                $uploadErrors = [
                    UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
                    UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
                    UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
                    UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
                    UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
                    UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
                    UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
                ];

                $file1Error = $_FILES['file1']['error'];
                $file2Error = $_FILES['file2']['error'];

                echo "<p class='error'>Error uploading files:</p>";
                if (isset($uploadErrors[$file1Error])) {
                    echo "<p>File 1: " . $uploadErrors[$file1Error] . "</p>";
                } else {
                    echo "<p>File 1: Unknown error code: $file1Error</p>";
                }

                if (isset($uploadErrors[$file2Error])) {
                    echo "<p>File 2: " . $uploadErrors[$file2Error] . "</p>";
                } else {
                    echo "<p>File 2: Unknown error code: $file2Error</p>";
                }
            }
        } else {
            echo "<p>Please upload both files.</p>";
        }
        ?>
    </div>
</body>
</html>
