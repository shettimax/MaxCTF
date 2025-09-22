<?php
require_once "confik.php"; // gives $conn
header('Content-Type: application/json');

// Ensure input
if (!isset($_POST['query']) || empty(trim($_POST['query']))) {
    echo json_encode(['status' => 'error', 'message' => 'No query given']);
    exit;
}

$ctfid = mysqli_real_escape_string($conn, trim($_POST['query']));

// Run query
$sql = "SELECT * FROM accounts WHERE ctfid = '$ctfid' LIMIT 1";
$res = mysqli_query($conn, $sql);

if (!$res) {
    echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    exit;
}

if (mysqli_num_rows($res) === 0) {
    echo json_encode(['status' => 'not_found', 'message' => 'No record for this CTFID']);
    exit;
}

$row = mysqli_fetch_assoc($res);

// Return JSON
echo json_encode([
    'status' => 'success',
    'data' => $row
]);
