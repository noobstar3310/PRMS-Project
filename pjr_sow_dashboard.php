<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="dashboard.css" rel="stylesheet" />
    <title>PJR-SOW Dashboard</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PJR-SOW Dashboard</a>
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
                        <a class="nav-link" href="add_option.php"><i class="fas fa-plus"></i> Add Record</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="upload_page.php"><i class="fas fa-file-excel"></i> Append File</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sow_cip_dashboard.php"><i class="fas fa-user"></i> SOW CIP
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
    <div class="container-fluid">
        <h1 class="text-dark mb-4">Dashboard</h1>

        <div class="row mb-4">
            <!-- Search by PR No -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card bg-info text-white shadow card-custom h-100">
                    <div class="card-body">
                        <h3>Search by PR No</h3>
                        <input type="text" id="searchPrInput" class="form-control" placeholder="Search by PR No">
                    </div>
                </div>
            </div>

            <!-- Dropdown Filters -->
            <div class="col-lg-8 col-md-6 mb-4">
                <div class="card bg-light text-dark shadow card-custom h-100">
                    <div class="card-body">
                        <h3 class="text-dark">Filter by BG, SOW No, and Working Group</h3>
                        <div class="row mb-3">
                            <!-- Filter by BG -->
                            <div class="col-md-4 mb-2">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle w-100" type="button"
                                        id="bgDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        Select BG
                                    </button>
                                    <ul class="dropdown-menu w-100" id="bgDropdownMenu">
                                        <li><a class="dropdown-item" href="#">BG1</a></li>
                                        <li><a class="dropdown-item" href="#">BG2</a></li>
                                        <li><a class="dropdown-item" href="#">BG3</a></li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Filter by SOW No -->
                            <div class="col-md-4 mb-2">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle w-100" type="button"
                                        id="sowDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        Select SOW No
                                    </button>
                                    <ul class="dropdown-menu w-100" id="sowDropdownMenu">
                                        <li><a class="dropdown-item" href="#">SOW1</a></li>
                                        <li><a class="dropdown-item" href="#">SOW2</a></li>
                                        <li><a class="dropdown-item" href="#">SOW3</a></li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Filter by Working Group -->
                            <div class="col-md-4 mb-2">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle w-100" type="button"
                                        id="workingGroupDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        Select Working Group
                                    </button>
                                    <ul class="dropdown-menu w-100" id="workingGroupDropdownMenu">
                                        <li><a class="dropdown-item" href="#">Group 1</a></li>
                                        <li><a class="dropdown-item" href="#">Group 2</a></li>
                                        <li><a class="dropdown-item" href="#">Group 3</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Apply Filters Button -->
                        <button class="btn btn-primary w-100 btn-custom" id="applyFilters"><i class="fas fa-filter"></i>
                            Apply Filters</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Records by Empty Fields Section -->
        <div class="accordion mb-4" id="filterAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="filterHeading">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                        <i class="fas fa-filter"></i> Filter Records by Empty Fields
                    </button>
                </h2>
                <div id="filterCollapse" class="accordion-collapse collapse" aria-labelledby="filterHeading"
                    data-bs-parent="#filterAccordion">
                    <div class="accordion-body">
                        <form method="GET" action="pjr_sow_dashboard.php" class="d-inline-block">
                            <input type="hidden" name="filter" value="capex_opex">
                            <button type="submit" class="btn-filter"><i class="fas fa-dollar-sign"></i> Show Empty
                                CAPEX/OPEX</button>
                        </form>
                        <form method="GET" action="pjr_sow_dashboard.php" class="d-inline-block">
                            <input type="hidden" name="filter" value="link">
                            <button type="submit" class="btn-filter"><i class="fas fa-link"></i> Show Empty
                                Link</button>
                        </form>
                        <form method="GET" action="pjr_sow_dashboard.php" class="d-inline-block">
                            <input type="hidden" name="filter" value="assigned_staff">
                            <button type="submit" class="btn-filter"><i class="fas fa-users"></i> Show Empty Assigned
                                Staff</button>
                        </form>
                        <button class="btn-filter" id="filterEmptySOW"><i class="fas fa-file-alt"></i> Show Empty SOW
                            No</button>
                        <button class="btn btn-danger btn-sm mt-2" id="clearFilters"
                            onclick="window.location.href='pjr_sow_dashboard.php';"><i class="fas fa-times"></i> Clear
                            Filters</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Record Table -->
        <div class="card mb-4 card-custom" style="margin: 20px;">
            <div class="card-header">
                <i class="fas fa-table"></i> Records
            </div>
            <div class="card-body">
                <div class="table-responsive scrollable-table">
                    <table id="recordsTable" class="table table-bordered table-striped">
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
                            <?php
                            include 'db_connect.php';
                            
                            // Default SQL query
                            $sql = "SELECT * FROM `pjr_sow`";
                            
                            // Handle filters submitted via PHP
                            if (isset($_GET['filter'])) {
                                $filter = $_GET['filter'];
                                
                                if ($filter == 'capex_opex') {
                                    $sql .= " WHERE (`Total CAPEX (USD)` IS NULL OR `Total CAPEX (USD)` = 0) AND (`Estimated OPEX (USD)` IS NULL OR `Estimated OPEX (USD)` = 0)";
                                } elseif ($filter == 'link') {
                                    $sql .= " WHERE `Link` IS NULL OR `Link` = ''";
                                } elseif ($filter == 'assigned_staff') {
                                    $sql .= " WHERE `Assigned_Staff` IS NULL OR `Assigned_Staff` = '' OR `Assigned_Staff` = '0'";
                                }
                            }
                            
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="filter.js"></script>
</body>

</html>