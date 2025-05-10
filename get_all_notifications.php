<?php
// get_all_notifications.php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/operations/db_connection.php';

$isAdmin = isset($_SESSION['admin_id']);
$isUser = isset($_SESSION['user_id']);

$out = ['notifications'=>[]];
if ($isAdmin || $isUser) {
    $where = [];
    $params = [];
    $types = '';
    if ($isAdmin) {
        $where[] = 'recipient_admin_id = ?';
        $params[] = $_SESSION['admin_id'];
        $types .= 'i';
    }
    if ($isUser) {
        $where[] = 'recipient_user_id = ?';
        $params[] = $_SESSION['user_id'];
        $types .= 'i';
    }
    if (!$where) $where[] = '1=0';
    $sql = "SELECT id, message, is_read, created_at FROM notifications WHERE (" . implode(' OR ', $where) . ") ORDER BY created_at DESC LIMIT 20";
    $stmt = $conn->prepare($sql);
    if ($types) $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $out['notifications'][] = [
            'id' => $row['id'],
            'message' => $row['message'],
            'is_read' => $row['is_read'],
            'created_at' => $row['created_at'],
        ];
    }
    $stmt->close();
}
echo json_encode($out);
