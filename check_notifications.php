<?php
// check_notifications.php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/operations/db_connection.php';
$adminId = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : null;
$newNotifications = [];

if ($adminId) {
    // Real DB check for unread notifications
    $stmt = $conn->prepare("SELECT id, message, created_at FROM admin_notifications WHERE admin_id = ? AND is_read = 0 ORDER BY created_at DESC LIMIT 10");
    $stmt->bind_param('i', $adminId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $newNotifications[] = [
            'message' => $row['message'],
            'timestamp' => strtotime($row['created_at']),
            'id' => $row['id']
        ];
    }
    $stmt->close();
    // Demo: Also add the simulated notification for testing
    if (date('s') < 10) {
        $newNotifications[] = [
            'message' => 'You have a new event update! (Demo)',
            'timestamp' => time(),
            'id' => 'demo-'.time()
        ];
    }
}

echo json_encode([
    'new_notifications' => $newNotifications
]);
