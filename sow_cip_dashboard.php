<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="dashboard.css" rel="stylesheet" />
    <title>SOW CIP Tracking Dashboard</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SOW CIP Tracking Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sow_cip_add_option.php"><i class="fas fa-plus"></i> Add Record</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="upload_page.php"><i class="fas fa-file-excel"></i> Append File</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pjr_sow_dashboard.php"><i class="fas fa-user"></i> PRMS
                            Tracking</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light" href="index.html"><i class="fas fa-sign-out-alt"></i>
                            Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <!-- New Filter Section -->
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card bg-info text-white shadow card-custom h-100">
                <div class="card-body">
                    <h3>Filter Records</h3>
                    <form method="GET" action="sow_cip_dashboard.php">
                        <button type="submit" name="filter" value="under_wai_yee" class="btn btn-light btn-block">
                            <i class="fas fa-filter"></i> Show Records Under Wai Yee
                        </button>
                    </form>
                    <?php if (isset($_GET['filter'])): ?>
                    <a href="sow_cip_dashboard.php" class="btn btn-danger btn-block mt-2">
                        <i class="fas fa-times"></i> Clear Filter
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card mb-4 card-custom" style="margin: 20px;">
            <div class="card-header">
                <i class="fas fa-table"></i> SOW CIP Records
            </div>
            <div class="card-body">
                <div class="table-responsive scrollable-table">
                    <table id="recordsTable" class="table table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>PR No</th>
                                <th>SOW No</th>
                                <th>CIP Required</th>
                                <th>CIP No</th>
                                <th>Electronic or Manual CIP</th>
                                <th>CIP Status</th>
                                <th>CIP Approved Date</th>
                                <th>BG</th>
                                <th>BU</th>
                                <th>Requestor</th>
                                <th>Project Manager Name</th>
                                <th>SOW Title</th>
                                <th>SOW Created Date</th>
                                <th>SOW Approved Date</th>
                                <th>SOW Status</th>
                                <th>Alert</th>
                                <th>Total Cost</th>
                                <th>BGFC</th>
                                <th>Kickoff Date</th>
                                <th>Go Live Date</th>
                                <th>Transition to Operation Date</th>
                                <th>Remarks</th>
                                <th>Under Wai Yee</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'db_connect.php';

                            // Query to fetch only the necessary columns from sow_cip table
                            $sql = "SELECT sow_cip_id, PR_No, SOW_No, CIP_Required, CIP_No, Electronic_or_Manual_CIP, CIP_Status, CIP_Approved_Date, 
                                    BG, BU, Requestor, Project_Manager_Name, SOW_Title, SOW_Created_Date, SOW_Approved_Date, SOW_Status, Alert, Total_Cost, BGFC, Kick_of_Date, Go_Live_Date, Transition_to_Operation,
                                    Remark, Under_WY FROM `sow_cip`";
                            // Add WHERE clause if the filter is set
                            if (isset($_GET['filter']) && $_GET['filter'] == 'under_wai_yee') {
                                $sql .= " WHERE Under_WY = 'YES'";
                            }

                            $result = $conn->query($sql);
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['PR_No']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['SOW_No']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['CIP_Required']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['CIP_No']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Electronic_or_Manual_CIP']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['CIP_Status']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['CIP_Approved_Date']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['BG']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['BU']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Requestor']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Project_Manager_Name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['SOW_Title']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['SOW_Created_Date']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['SOW_Approved_Date']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['SOW_Status']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Alert']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Total_Cost']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['BGFC']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Kick_of_Date']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Go_Live_Date']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Transition_to_Operation']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Remark']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Under_WY']) . "</td>";
                                   
                                    echo "<td>
                                            <div class='btn-group'>
                                                <a class='btn btn-secondary' href='./update_record_form_sowcip.php?id=" . $row['sow_cip_id'] . "'>Update</a>
                                                <a class='btn btn-danger' href='./delete_record.php?id=" . $row['sow_cip_id'] . "'>Delete</a>
                                            </div>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='15' class='text-center'>No records found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="filter.js"></script>
</body>

</html>