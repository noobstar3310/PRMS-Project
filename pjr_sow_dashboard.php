<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="boostrap_style.css" rel="stylesheet" type="text/css" />
    <title>Bootstrap 5 Responsive Admin Dashboard</title>
    <style>
    .scrollable-table {
        overflow-x: auto;
        white-space: nowrap;
        width: 100%;
        max-width: 100%;
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

    .danger-button {
        background-color: #d9534f;
        color: white;
    }

    .danger-button:hover {
        background-color: #c9302c;
    }
    </style>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">PJR-SOW Dashboard</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><a class="dropdown-item" href="#">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="row my-5">
                <form action="landing_page.php" method="post">
                    <button type="button" onclick="window.location.href = 'landing_page.php'">Home</button>
                </form>
                <form action="add_option.php" method="post">
                    <button type="button" onclick="window.location.href = 'add_option.php'">Add Record</button>
                </form>
                <!-- Update with Excel Button -->
                <form action="update_with_excel.php" method="post" enctype="multipart/form-data">
                    <button type="button" onclick="window.location.href = 'update_via_excel.php'"
                        class="button secondary-button">Update with Excel</button>
                </form>
            </div>

            <div class="col-md-6 search-bar">
                <!-- Search by PR No Form -->
                <form action="pjr_sow_dashboard.php" method="get" style="display: inline-block;">
                    <input type="text" name="search" placeholder="Search by PR No">
                    <button type="submit">Search</button>
                </form>

                <!-- Filter Records by Empty SOW No Form -->
                <form action="pjr_sow_dashboard.php" method="get" style="display: inline-block;">
                    <input type="hidden" name="filter_empty_sow" value="1">
                    <button type="submit">Show Records with Empty SOW No</button>
                </form>

                <!-- Filter Records by Empty CAPEX or OPEX Form -->
                <form action="pjr_sow_dashboard.php" method="get" style="display: inline-block;">
                    <input type="hidden" name="filter_empty_capex_opex" value="1">
                    <button type="submit">Show Records with Empty CAPEX or OPEX</button>
                </form>

                <!-- Filter Records by Empty Assigned Staff Form -->
                <form action="pjr_sow_dashboard.php" method="get" style="display: inline-block;">
                    <input type="hidden" name="filter_empty_assigned_staff" value="1">
                    <button type="submit">Show Records with Empty Assigned Staff</button>
                </form>

                <!-- Filter Records by Empty Link Form -->
                <form action="pjr_sow_dashboard.php" method="get" style="display: inline-block;">
                    <input type="hidden" name="filter_empty_link" value="1">
                    <button type="submit">Show Records with Empty Link</button>
                </form>

                <!-- Clear Filter Button -->
                <button class="danger-button" onclick="window.location.href = 'pjr_sow_dashboard.php'">Clear
                    Filter</button>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->
    <div class="col scrollable-table">
        <h3 class="fs-4 mb-3">Records</h3>
        <?php
        include 'db_connect.php';

        // Initialize variables for search and filter
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $filterEmptySOW = isset($_GET['filter_empty_sow']) ? $_GET['filter_empty_sow'] : '';
        $filterEmptyCapexOpex = isset($_GET['filter_empty_capex_opex']) ? $_GET['filter_empty_capex_opex'] : '';
        $filterEmptyAssignedStaff = isset($_GET['filter_empty_assigned_staff']) ? $_GET['filter_empty_assigned_staff'] : '';
        $filterEmptyLink = isset($_GET['filter_empty_link']) ? $_GET['filter_empty_link'] : '';

        // Build the base SQL query
        $sql = "SELECT * FROM `pjr_sow` WHERE 1=1"; // Using '1=1' to make it easier to add conditions

        // Apply search filter if search term is provided
        if ($search) {
            $sql .= " AND `PR_No` LIKE '%" . $conn->real_escape_string($search) . "%'";
        }

        // Apply filter for empty SOW No if the button is clicked
        if ($filterEmptySOW) {
            $sql .= " AND (TRIM(`SOW_No`) = '' OR `SOW_No` IS NULL OR TRIM(`SOW_No`) = 'SOW Is Required')";
        }

        // Apply filter for empty CAPEX or OPEX, except for records with "SOW Not Required"
        if ($filterEmptyCapexOpex) {
            $sql .= " AND ((`Total CAPEX (USD)` IS NULL OR `Total CAPEX (USD)` = 0 OR `Estimated OPEX (USD)` IS NULL OR `Estimated OPEX (USD)` = 0) AND `SOW_No` != 'SOW Not Required')";
        }

        // Apply filter for empty Assigned Staff
        if ($filterEmptyAssignedStaff) {
            $sql .= " AND (TRIM(`Assigned_Staff`) = '' OR `Assigned_Staff` IS NULL)";
        }

        // Apply filter for empty Link
        if ($filterEmptyLink) {
            $sql .= " AND (TRIM(`Link`) = '' OR `Link` IS NULL)";
        }

        $result = $conn->query($sql);

        // Check if there are results
        if ($result && $result->num_rows > 0) {
            // Start the HTML table
            echo "<table class='table bg-white rounded shadow-sm table-hover'>";
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

            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['BG'] . "</td>";
                echo "<td>" . $row['BU'] . "</td>";
                echo "<td>" . $row['Title'] . "</td>";
                echo "<td>" . $row['PR_No'] . "</td>";
                echo "<td>" . $row['SOW_No'] . "</td>";
                echo "<td>" . $row['Requestor'] . "</td>";
                echo "<td>" . $row['Created_Date'] . "</td>";
                echo "<td>" . $row['Working_Group'] . "</td>";
                echo "<td>" . $row['Budgeted'] . "</td>";
                echo "<td>" . $row['Assigned_Staff'] . "</td>";
                echo "<td>" . $row['Benefits'] . "</td>";
                echo "<td>" . $row['Savings'] . "</td>";
                echo "<td>" . $row['Risk'] . "</td>";
                echo "<td>" . $row['Budget_Amo'] . "</td>";
                echo "<td>" . $row['Scoping_Lead_Time'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "<td>" . $row['PMO_Status'] . "</td>";
                echo "<td>" . $row['Link'] . "</td>";
                echo "<td>" . $row['Total CAPEX (USD)'] . "</td>";
                echo "<td>" . $row['Estimated OPEX (USD)'] . "</td>";
                echo "<td>" . $row['Remarks'] . "</td>";
                echo "<td>";
                echo "<div class='btn-group'>";
                echo "<a class='btn btn-secondary' href='./update_record_form.php?id=" . $row['pjr_sow_id'] . "'>Update</a>";
                echo "<a class='btn btn-danger' href='./delete_record.php?id=" . $row['pjr_sow_id'] . "'>Delete</a>";
                echo "</div>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "0 results or query error: " . $conn->error;
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    var el = document.getElementById("wrapper");
    var toggleButton = document.getElementById("menu-toggle");

    toggleButton.onclick = function() {
        el.classList.toggle("toggled");
    };
    </script>
</body>

</html>