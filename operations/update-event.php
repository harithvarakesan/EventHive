<?php
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['host_id'])) {
    header("Location: ../login.php");
    exit;
}
include './db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $short_description = trim($_POST['short_description']);
    $long_description = trim($_POST['long_description']);
    $eligibility = trim($_POST['eligibility']);
    $type = trim($_POST['type']);
    $start_date = trim($_POST['start_date']);
    $end_date = trim($_POST['end_date']);
    $deadline_date = trim($_POST['deadline_date']);
    $location = trim($_POST['location']);
    $coordinator = trim($_POST['coordinator']);
    $coordinator_number = trim($_POST['coordinator_number']);
    $coordinator_emailid = trim($_POST['coordinator_emailid']);
    $prize = trim($_POST['prize']);
    $website = trim($_POST['website']);

    $sql = "UPDATE event SET name=?, short_description=?, long_description=?, eligibility=?, type=?, start_date=?, end_date=?, deadline_date=?, location=?, coordinator=?, coordinator_number=?, coordinator_emailid=?, prize=?, website=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo "<script>alert('Failed to prepare statement: " . $conn->error . "'); window.history.back();</script>";
        exit;
    }
    $stmt->bind_param(
        "ssssssssssssssi",
        $name, $short_description, $long_description, $eligibility, $type, $start_date, $end_date, $deadline_date, $location, $coordinator, $coordinator_number, $coordinator_emailid, $prize, $website, $id
    );
    if ($stmt->execute()) {
        echo "<script>alert('Event updated successfully!'); window.location.href='../admin-event-detail.php?id=$id';</script>";
        exit;
    } else {
        echo "<script>alert('Failed to update event: " . $stmt->error . "'); window.history.back();</script>";
        exit;
    }
    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
    exit;
}
?>
