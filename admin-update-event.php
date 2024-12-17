<?php

include 'admin-header.php';
include './operations/db_connection.php';

// Fetch event details
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $eventId = intval($_GET['id']);
    $hostId = $_SESSION['host_id']; // Ensure this is set in the session

    // Fetch event details from the database
    $query = "SELECT name, start_date, end_date, deadline_date, long_description, eligibility, type, location, prize, website, coordinator FROM event WHERE id = ? AND host = ?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("ii", $eventId, $hostId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $event = $result->fetch_assoc();
        } else {
            echo "<script>alert('Event not found or you are not authorized to update this event.'); window.history.back();</script>";
            exit();
        }
    } else {
        die("Query preparation failed: " . $conn->error);
    }
} else {
    echo "<script>alert('Invalid event ID.'); window.history.back();</script>";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventName = trim($_POST['event-name']);
    $eventStartDate = trim($_POST['event-start-date']);
    $eventEndDate = trim($_POST['event-end-date']);
    $eventDeadlineDate = trim($_POST['event-deadline-date']);
    $eventEligibility = trim($_POST['event-eligibility']);
    $eventType = trim($_POST['event-type']);
    $eventPrize = trim($_POST['event-prize']);
    $eventDescription = trim($_POST['event-description']);
    $eventLocation = trim($_POST['event-location']);
    $eventWebsite = trim($_POST['event-website']);
    $eventCoordinator = trim($_POST['event-coordinator']);

    // Update event details in the database
    $updateQuery = "UPDATE event SET name = ?, start_date = ?, end_date = ?, deadline_date = ?, long_description = ?, eligibility = ?, type = ?, location = ?, prize = ?, website = ?, coordinator = ? WHERE id = ? AND host = ?";
    $updateStmt = $conn->prepare($updateQuery);
    if ($updateStmt) {
        $updateStmt->bind_param("ssssssssssssi", $eventName, $eventStartDate, $eventEndDate, $eventDeadlineDate, $eventDescription, $eventEligibility, $eventType, $eventLocation, $eventPrize, $eventWebsite, $eventCoordinator, $eventId, $hostId);
        if ($updateStmt->execute()) {
            echo "<script>alert('Event updated successfully!'); window.location.href = 'admin-your-events.php';</script>";
        } else {
            echo "<script>alert('Failed to update event.');</script>";
        }
    } else {
        die("Query preparation failed: " . $conn->error);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Event</title>
    <link rel="stylesheet" href="./assets/css/admin-update-event.css">
</head>
<body>
    <header class="update_event">
        <h2>Update Event</h2>
    </header>

    <main class="update-event-container">
        <form id="update-event-form" method="POST">
            <div class="form-group">
                <label for="event-name">Event Name</label>
                <input type="text" id="event-name" name="event-name" value="<?php echo htmlspecialchars($event['name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="event-start-date">Event Start Date</label>
                <input type="datetime-local" id="event-start-date" name="event-start-date" value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($event['start_date']))); ?>" required>
            </div>

            <div class="form-group">
                <label for="event-end-date">Event End Date</label>
                <input type="datetime-local" id="event-end-date" name="event-end-date" value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($event['end_date']))); ?>" required>
            </div>

            <div class="form-group">
                <label for="event-deadline-date">Event Deadline Date</label>
                <input type="datetime-local" id="event-deadline-date" name="event-deadline-date" value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($event['deadline_date']))); ?>" required>
            </div>

            <div class="form-group">
                <label for="event-eligibility">Event Eligibility</label>
                <textarea id="event-eligibility" name="event-eligibility" rows="5" required><?php echo htmlspecialchars($event['eligibility']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="event-type">Event Type</label>
                <input type="text" id="event-type" name="event-type" value="<?php echo htmlspecialchars($event['type']); ?>" required>
            </div>

            <div class="form-group">
                <label for="event-prize">Event Prize</label>
                <input type="text" id="event-prize" name="event-prize" value="<?php echo htmlspecialchars($event['prize']); ?>" required>
            </div>

            <div class="form-group">
                <label for="event-description">Event Description</label>
                <textarea id="event-description" name="event-description" rows="5" required><?php echo htmlspecialchars($event['long_description']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="event-location">Event Location</label>
                <input type="text" id="event-location" name="event-location" value="<?php echo htmlspecialchars($event['location']); ?>" required>
            </div>

            <div class="form-group">
                <label for="event-website">Event Website</label>
                <input type="text" id="event-website" name="event-website" value="<?php echo htmlspecialchars($event['website']); ?>" required>
            </div>

            <div class="form-group">
                <label for="event-coordinator">Event Coordinator</label>
                <input type="text" id="event-coordinator" name="event-coordinator" value="<?php echo htmlspecialchars($event['coordinator']); ?>" required>
            </div>

            <button type="submit" class="submit-btn">Update Event</button>
        </form>
    </main>
</body>
</html>
