<?php
// mark_notifications_read.php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['ids']) || !is_array($data['ids'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
    exit;
}

require_once __DIR__ . '/operations/db_connection.php';
$adminId = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : null;
if (!$adminId) {
    http_response_code(403);
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

$ids = array_filter($data['ids'], 'is_numeric');
if (empty($ids)) {
    echo json_encode(['success' => true]); // nothing to do
    exit;
}

$idList = implode(',', array_map('intval', $ids));
$sql = "UPDATE admin_notifications SET is_read = 1 WHERE admin_id = $adminId AND id IN ($idList)";
$conn->query($sql);
echo json_encode(['success' => true]);
