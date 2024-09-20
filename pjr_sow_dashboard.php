<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <title>PJR-SOW Dashboard</title>
    <style>
    body,
    html {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    .scrollable-table {
        overflow-x: auto;
        white-space: nowrap;
        width: 100%;
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

    .dropdown-menu {
        max-height: 200px;
        overflow-y: auto;
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
                        <a class="nav-link" href="landing_page.php">Home</a>
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

        <div class="row mb-4">
            <!-- Search by PR No -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card bg-info text-white shadow card-custom h-100">
                    <div class="card-body">
                        <h2>Search by PR No</h2>
                    </div>
                    <div class="card-footer">
                        <input type="text" id="searchPrInput" class="form-control mb-2" placeholder="Search by PR No">
                    </div>
                </div>
            </div>

            <!-- Dropdown Filters -->
            <div class="col-lg-8 col-md-6 mb-4">
                <div class="card bg-light text-dark shadow card-custom h-100">
                    <div class="card-body">
                        <h2>Filter by BG, SOW No, and Working Group</h2>
                    </div>
                    <div class="card-footer">
                        <div class="row mb-2">
                            <!-- Filter by BG -->
                            <div class="col-4">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="bgDropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Select BG
                                    </button>
                                    <ul class="dropdown-menu" id="bgDropdownMenu"></ul>
                                </div>
                            </div>

                            <!-- Filter by SOW No -->
                            <div class="col-4">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="sowDropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Select SOW No
                                    </button>
                                    <ul class="dropdown-menu" id="sowDropdownMenu"></ul>
                                </div>
                            </div>

                            <!-- Filter by Working Group -->
                            <div class="col-4">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="workingGroupDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        Select Working Group
                                    </button>
                                    <ul class="dropdown-menu" id="workingGroupDropdownMenu"></ul>
                                </div>
                            </div>
                        </div>
                        <!-- Apply Filters Button -->
                        <div class="text-end">
                            <button class="btn btn-primary btn-custom" id="applyFilters">Apply Filters</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Records by Empty Fields -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card bg-warning text-dark shadow card-custom h-100">
                    <div class="card-body">
                        <h2>Filter Records by Empty Fields</h2>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-dark btn-sm btn-custom" id="filterEmptySOW">Show Empty SOW No</button>
                        <button class="btn btn-dark btn-sm btn-custom" id="filterEmptyCapexOpex">Show Empty
                            CAPEX/OPEX</button>
                        <button class="btn btn-dark btn-sm btn-custom" id="filterEmptyAssignedStaff">Show Empty Assigned
                            Staff</button>
                        <button class="btn btn-dark btn-sm btn-custom" id="filterEmptyLink">Show Empty Link</button>
                        <button class="btn btn-danger btn-sm btn-custom mt-2" id="clearFilters">Clear Filters</button>
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
                    <table id="recordsTable" class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>BG</th>
                                <th>BU</th>
                                <th>Title</th>
                                <th>PJR NO</th>
                                <th>SOW NO</th>
                                <th>Requestor</th>
                                <th>Created Date</th>
                                <th>Working Group</th>
                                <th>Budgeted</th>
                                <th>Assigned Staff</th>
                                <th>Benefits</th>
                                <th>Savings</th>
                                <th>Risk</th>
                                <th>Budget Amo</th>
                                <th>Scoping Lead Time</th>
                                <th>Status</th>
                                <th>PMO Status</th>
                                <th>Link</th>
                                <th>Total CAPEX (USD)</th>
                                <th>Estimated OPEX (USD)</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Rows will be dynamically inserted here -->
                            <?php
                            include 'db_connect.php';
                            $sql = "SELECT * FROM `pjr_sow`";
                            $result = $conn->query($sql);
                            if ($result && $result->num_rows > 0) {
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
                                    echo "<td>
                                        <div class='btn-group'>
                                            <a class='btn btn-secondary' href='./update_record_form.php?id=" . $row['pjr_sow_id'] . "'>Update</a>
                                            <a class='btn btn-danger' href='./delete_record.php?id=" . $row['pjr_sow_id'] . "'>Delete</a>
                                        </div>
                                    </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='21' class='text-center'>No records found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- External JS for filtering logic -->
    <script src="filter.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>