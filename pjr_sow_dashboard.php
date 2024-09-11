<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="boostrap_style.css" rel="stylesheet" type="text/css" />
    <title>PJR-SOW Dashboard</title>
    <style>
    .scrollable-table {
        overflow-x: auto;
        white-space: nowrap;
        width: 100%;
        max-width: 100%;
    }

    .navbar-custom {
        background-color: #007bff;
    }

    .navbar-custom .navbar-brand,
    .navbar-custom .nav-link {
        color: #ffffff;
    }

    .card-custom {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-custom {
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 16px;
        margin: 10px 0;
    }

    .btn-custom-primary {
        background-color: #007bff;
        color: white;
    }

    .btn-custom-primary:hover {
        background-color: #0056b3;
    }

    .btn-custom-danger {
        background-color: #d9534f;
        color: white;
    }

    .btn-custom-danger:hover {
        background-color: #c9302c;
    }
    </style>
</head>

<body>
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PJR-SOW Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="landing_page.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_option.php">Add Record</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="update_via_excel.php">Update with Excel</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <div class="row mb-4 d-flex align-items-stretch">
            <!-- Search by PR No -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card bg-info text-white shadow card-custom h-100">
                    <div class="card-body">
                        <h2>Search by PR No</h2>
                    </div>
                    <div class="card-footer">
                        <form action="pjr_sow_dashboard.php" method="get">
                            <input type="text" name="search" class="form-control mb-2" placeholder="Search by PR No">
                            <button type="submit" class="btn btn-light btn-sm btn-custom">Search</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Dropdown Filters -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card bg-light text-dark shadow card-custom h-100">
                    <div class="card-body">
                        <h2>Filter by BG, SOW No, and Working Group</h2>
                    </div>
                    <div class="card-footer">
                        <form action="pjr_sow_dashboard.php" method="post">
                            <div class="row mb-2">
                                <!-- Filter by BG -->
                                <div class="col-4">
                                    <select class="form-control" name="BG">
                                        <option>Select BG</option>
                                        <?php
                                    include 'db_connect.php';
                                    $query = "SELECT DISTINCT BG FROM pjr_sow WHERE BG IS NOT NULL AND BG != ''";
                                    $result = mysqli_query($conn, $query) or die('error');
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='" . htmlspecialchars($row['BG']) . "'>" . htmlspecialchars($row['BG']) . "</option>";
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>

                                <!-- Filter by SOW No -->
                                <div class="col-4">
                                    <select class="form-control" name="SOW_No">
                                        <option>Select SOW No</option>
                                        <?php
                                    $query = "SELECT DISTINCT SOW_No FROM pjr_sow WHERE SOW_No IS NOT NULL AND SOW_No != ''";
                                    $result = mysqli_query($conn, $query) or die('error');
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='" . htmlspecialchars($row['SOW_No']) . "'>" . htmlspecialchars($row['SOW_No']) . "</option>";
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>

                                <!-- Filter by Working Group -->
                                <div class="col-4">
                                    <select class="form-control" name="Working_Group">
                                        <option>Select Working Group</option>
                                        <?php
                                    $query = "SELECT DISTINCT Working_Group FROM pjr_sow WHERE Working_Group IS NOT NULL AND Working_Group != ''";
                                    $result = mysqli_query($conn, $query) or die('error');
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='" . htmlspecialchars($row['Working_Group']) . "'>" . htmlspecialchars($row['Working_Group']) . "</option>";
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <!-- Submit Button for Filters -->
                            <div class="text-end">
                                <input type="submit" name="submit" class="btn btn-primary btn-custom"
                                    value="Apply Filters">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Filter Records by Empty Fields -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card bg-warning text-dark shadow card-custom h-100">
                    <div class="card-body">
                        <h2>Filter Records</h2>
                    </div>
                    <div class="card-footer">
                        <form action="pjr_sow_dashboard.php" method="get">
                            <input type="hidden" name="filter_empty_sow" value="1">
                            <button type="submit" class="btn btn-dark btn-sm btn-custom">Show Empty SOW No</button>
                        </form>
                        <form action="pjr_sow_dashboard.php" method="get" class="mt-2">
                            <input type="hidden" name="filter_empty_capex_opex" value="1">
                            <button type="submit" class="btn btn-dark btn-sm btn-custom">Show Empty CAPEX/OPEX</button>
                        </form>
                        <form action="pjr_sow_dashboard.php" method="get" class="mt-2">
                            <input type="hidden" name="filter_empty_assigned_staff" value="1">
                            <button type="submit" class="btn btn-dark btn-sm btn-custom">Show Empty Assigned
                                Staff</button>
                        </form>
                        <form action="pjr_sow_dashboard.php" method="get" class="mt-2">
                            <input type="hidden" name="filter_empty_link" value="1">
                            <button type="submit" class="btn btn-dark btn-sm btn-custom">Show Empty Link</button>
                        </form>
                        <button class="btn btn-danger btn-sm btn-custom mt-2"
                            onclick="window.location.href = 'pjr_sow_dashboard.php'">Clear Filters</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Record Table -->
    <div class="card mb-4 card-custom" style="margin: 20px;">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Records
        </div>
        <div class="card-body">
            <div class="table-responsive scrollable-table">
                <?php
                    include 'db_connect.php';

                    // Initialize variables for search and filter
                    $search = isset($_GET['search']) ? $_GET['search'] : '';
                    $filterEmptySOW = isset($_GET['filter_empty_sow']) ? $_GET['filter_empty_sow'] : '';
                    $filterEmptyCapexOpex = isset($_GET['filter_empty_capex_opex']) ? $_GET['filter_empty_capex_opex'] : '';
                    $filterEmptyAssignedStaff = isset($_GET['filter_empty_assigned_staff']) ? $_GET['filter_empty_assigned_staff'] : '';
                    $filterEmptyLink = isset($_GET['filter_empty_link']) ? $_GET['filter_empty_link'] : '';

                    // Get filter values from the form (POST method)
                    $selectedBG = isset($_POST['BG']) ? $_POST['BG'] : '';
                    $selectedSOWNo = isset($_POST['SOW_No']) ? $_POST['SOW_No'] : '';
                    $selectedWorkingGroup = isset($_POST['Working_Group']) ? $_POST['Working_Group'] : '';

                    // Build the base SQL query
                    $sql = "SELECT * FROM `pjr_sow` WHERE 1=1";

                    // Apply search filter if search term is provided
                    if ($search) {
                        $sql .= " AND `PR_No` LIKE '%" . $conn->real_escape_string($search) . "%'";
                    }

                    // Apply dropdown filters if selected
                    if ($selectedBG && $selectedBG != 'Select BG') {
                        $sql .= " AND `BG` = '" . $conn->real_escape_string($selectedBG) . "'";
                    }

                    if ($selectedSOWNo && $selectedSOWNo != 'Select SOW No') {
                        $sql .= " AND `SOW_No` = '" . $conn->real_escape_string($selectedSOWNo) . "'";
                    }

                    if ($selectedWorkingGroup && $selectedWorkingGroup != 'Select Working Group') {
                        $sql .= " AND `Working_Group` = '" . $conn->real_escape_string($selectedWorkingGroup) . "'";
                    }

                    // Apply additional filters
                    if ($filterEmptySOW) {
                        $sql .= " AND (TRIM(`SOW_No`) = '' OR `SOW_No` IS NULL OR TRIM(`SOW_No`) = 'SOW Is Required')";
                    }

                    if ($filterEmptyCapexOpex) {
                        $sql .= " AND ((`Total CAPEX (USD)` IS NULL OR `Total CAPEX (USD)` = 0 OR `Estimated OPEX (USD)` IS NULL OR `Estimated OPEX (USD)` = 0) AND `SOW_No` != 'SOW Not Required')";
                    }

                    if ($filterEmptyAssignedStaff) {
                        $sql .= " AND (TRIM(`Assigned_Staff`) = '' OR `Assigned_Staff` IS NULL)";
                    }

                    if ($filterEmptyLink) {
                        $sql .= " AND (TRIM(`Link`) = '' OR `Link` IS NULL)";
                    }

                    // Execute the SQL query
                    $result = $conn->query($sql);

                    // Check if there are results
                    if ($result && $result->num_rows > 0) {
                        echo "<table class='table table-bordered'>";
                        echo "<thead class='thead-light'>";
                        echo "<tr>";
                        echo "<th>BG</th>";
                        echo "<th>BU</th>";
                        echo "<th>Title</th>";
                        echo "<th>PJR NO</th>";
                        echo "<th>SOW NO</th>";
                        echo "<th>Requestor</th>";
                        echo "<th>Created Date</th>";
                        echo "<th>Working Group</th>";
                        echo "<th>Budgeted</th>";
                        echo "<th>Assigned Staff</th>";
                        echo "<th>Benefits</th>";
                        echo "<th>Savings</th>";
                        echo "<th>Risk</th>";
                        echo "<th>Budget Amo</th>";
                        echo "<th>Scoping Lead Time</th>";
                        echo "<th>Status</th>";
                        echo "<th>PMO Status</th>";
                        echo "<th>Link</th>";
                        echo "<th>Total CAPEX (USD)</th>";
                        echo "<th>Estimated OPEX (USD)</th>";
                        echo "<th>Remarks</th>";
                        echo "<th>Action</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['BG']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['BU']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Title']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['PR_No']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['SOW_No']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Requestor']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Created_Date']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Working_Group']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Budgeted']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Assigned_Staff']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Benefits']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Savings']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Risk']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Budget_Amo']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Scoping_Lead_Time']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['PMO_Status']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Link']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Total CAPEX (USD)']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Estimated OPEX (USD)']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Remarks']) . "</td>";
                            echo "<td>";
                            echo "<div class='btn-group'>";
                            echo "<a class='btn btn-secondary' href='./update_record_form.php?id=" . $row['pjr_sow_id'] . "'>Update</a>";
                            echo "<a class='btn btn-danger' href='./delete_record.php?id=" . $row['pjr_sow_id'] . "'>Delete</a>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                    } else {
                        echo "<div class='alert alert-warning'>0 results or query error: " . htmlspecialchars($conn->error) . "</div>";
                    }
                    ?>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>