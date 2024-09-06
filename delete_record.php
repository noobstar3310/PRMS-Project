<?php
include 'db_connect.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the DELETE query
    $sql = "DELETE FROM pjr_sow WHERE pjr_sow_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Record deleted successfully!";
        header("Location: pjr_sow_dashboard.php");
        exit();
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
}


$conn->close();