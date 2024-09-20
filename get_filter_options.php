<?php
include 'db_connect.php';

// Initialize the response array
$response = [
    'bgs' => [],
    'sowNos' => [],
    'workingGroups' => []
];

// Check which parameter is set
$bg = isset($_POST['BG']) ? $_POST['BG'] : '';
$sowNo = isset($_POST['SOW_No']) ? $_POST['SOW_No'] : '';
$workingGroup = isset($_POST['Working_Group']) ? $_POST['Working_Group'] : '';

// If BG is selected, fetch corresponding SOW No and Working Groups
if ($bg) {
    $querySowNo = "SELECT DISTINCT SOW_No FROM pjr_sow WHERE BG = ? AND SOW_No IS NOT NULL AND SOW_No != ''";
    $stmtSowNo = $conn->prepare($querySowNo);
    $stmtSowNo->bind_param("s", $bg);
    $stmtSowNo->execute();
    $resultSowNo = $stmtSowNo->get_result();

    while ($row = $resultSowNo->fetch_assoc()) {
        $response['sowNos'][] = $row['SOW_No'];
    }

    $queryWorkingGroup = "SELECT DISTINCT Working_Group FROM pjr_sow WHERE BG = ? AND Working_Group IS NOT NULL AND Working_Group != ''";
    $stmtWorkingGroup = $conn->prepare($queryWorkingGroup);
    $stmtWorkingGroup->bind_param("s", $bg);
    $stmtWorkingGroup->execute();
    $resultWorkingGroup = $stmtWorkingGroup->get_result();

    while ($row = $resultWorkingGroup->fetch_assoc()) {
        $response['workingGroups'][] = $row['Working_Group'];
    }
}

// If SOW No is selected, fetch corresponding BGs and Working Groups
if ($sowNo) {
    $queryBG = "SELECT DISTINCT BG FROM pjr_sow WHERE SOW_No = ? AND BG IS NOT NULL AND BG != ''";
    $stmtBG = $conn->prepare($queryBG);
    $stmtBG->bind_param("s", $sowNo);
    $stmtBG->execute();
    $resultBG = $stmtBG->get_result();

    while ($row = $resultBG->fetch_assoc()) {
        $response['bgs'][] = $row['BG'];
    }

    $queryWorkingGroup = "SELECT DISTINCT Working_Group FROM pjr_sow WHERE SOW_No = ? AND Working_Group IS NOT NULL AND Working_Group != ''";
    $stmtWorkingGroup = $conn->prepare($queryWorkingGroup);
    $stmtWorkingGroup->bind_param("s", $sowNo);
    $stmtWorkingGroup->execute();
    $resultWorkingGroup = $stmtWorkingGroup->get_result();

    while ($row = $resultWorkingGroup->fetch_assoc()) {
        $response['workingGroups'][] = $row['Working_Group'];
    }
}

// If Working Group is selected, fetch corresponding BGs and SOW Nos
if ($workingGroup) {
    $queryBG = "SELECT DISTINCT BG FROM pjr_sow WHERE Working_Group = ? AND BG IS NOT NULL AND BG != ''";
    $stmtBG = $conn->prepare($queryBG);
    $stmtBG->bind_param("s", $workingGroup);
    $stmtBG->execute();
    $resultBG = $stmtBG->get_result();

    while ($row = $resultBG->fetch_assoc()) {
        $response['bgs'][] = $row['BG'];
    }

    $querySowNo = "SELECT DISTINCT SOW_No FROM pjr_sow WHERE Working_Group = ? AND SOW_No IS NOT NULL AND SOW_No != ''";
    $stmtSowNo = $conn->prepare($querySowNo);
    $stmtSowNo->bind_param("s", $workingGroup);
    $stmtSowNo->execute();
    $resultSowNo = $stmtSowNo->get_result();

    while ($row = $resultSowNo->fetch_assoc()) {
        $response['sowNos'][] = $row['SOW_No'];
    }
}

// If no filters are selected, fetch all options
if (!$bg && !$sowNo && !$workingGroup) {
    // Fetch all BGs
    $queryBG = "SELECT DISTINCT BG FROM pjr_sow WHERE BG IS NOT NULL AND BG != ''";
    $resultBG = $conn->query($queryBG);
    while ($row = $resultBG->fetch_assoc()) {
        $response['bgs'][] = $row['BG'];
    }

    // Fetch all SOW Nos
    $querySowNo = "SELECT DISTINCT SOW_No FROM pjr_sow WHERE SOW_No IS NOT NULL AND SOW_No != ''";
    $resultSowNo = $conn->query($querySowNo);
    while ($row = $resultSowNo->fetch_assoc()) {
        $response['sowNos'][] = $row['SOW_No'];
    }

    // Fetch all Working Groups
    $queryWorkingGroup = "SELECT DISTINCT Working_Group FROM pjr_sow WHERE Working_Group IS NOT NULL AND Working_Group != ''";
    $resultWorkingGroup = $conn->query($queryWorkingGroup);
    while ($row = $resultWorkingGroup->fetch_assoc()) {
        $response['workingGroups'][] = $row['Working_Group'];
    }
}

// Return data as JSON
echo json_encode($response);
?>