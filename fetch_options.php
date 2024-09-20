<?php
include 'db_connect.php';

if (isset($_GET['bg'])) {
    $bg = $_GET['bg'];

    // Prepare response array
    $response = [
        'sowNumbers' => [],
        'workingGroups' => []
    ];

    // Fetch SOW Numbers based on selected BG
    $querySow = "SELECT DISTINCT SOW_No FROM pjr_sow WHERE BG = ? AND SOW_No IS NOT NULL AND SOW_No != ''";
    $stmtSow = $conn->prepare($querySow);
    $stmtSow->bind_param("s", $bg);
    $stmtSow->execute();
    $resultSow = $stmtSow->get_result();
    while ($row = $resultSow->fetch_assoc()) {
        $response['sowNumbers'][] = $row['SOW_No'];
    }

    // Fetch Working Groups based on selected BG
    $queryWG = "SELECT DISTINCT Working_Group FROM pjr_sow WHERE BG = ? AND Working_Group IS NOT NULL AND Working_Group != ''";
    $stmtWG = $conn->prepare($queryWG);
    $stmtWG->bind_param("s", $bg);
    $stmtWG->execute();
    $resultWG = $stmtWG->get_result();
    while ($row = $resultWG->fetch_assoc()) {
        $response['workingGroups'][] = $row['Working_Group'];
    }

    // Return JSON response
    echo json_encode($response);
}
?>