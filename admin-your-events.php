<?php
include 'admin-header.php';
include './operations/db_connection.php';

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_event_id'])) {
    $deleteEventId = $_POST['delete_event_id'];
    $deleteSql = "DELETE FROM event WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    
    if ($deleteStmt) {
        $deleteStmt->bind_param("i", $deleteEventId);
        if ($deleteStmt->execute()) {
            echo "<script>
                alert('Event deleted successfully!');
                window.location.href = 'your-events.php';
                </script>";
        } else {
            echo "<script>alert('Failed to delete the event.');</script>";
        }
        $deleteStmt->close();
    }
}

// Get the host ID from the session
$hostId = isset($_SESSION['host_id']) ? $_SESSION['host_id'] : null;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Events</title>
    <link rel="stylesheet" href="./assets/css/admin-your-events.css">
</head>
<body>

    <main class="your-events-container">
        <h2>Your Events</h2>

        <!-- Filter Form -->
        <div class="filter-container">
            <input type="text" id="event-name-input" placeholder="Search by Event Name" onkeyup="filterEvents()" />
        </div>

        <div class="events-list" id="events-list">
            <?php
            if ($hostId) {
                $sql = "SELECT id, name, start_date, end_date, short_description FROM event WHERE host = ?";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    $stmt->bind_param("i", $hostId);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "
                            <div class='event-card' data-name='" . strtolower($row['name']) . "'>
                                <h3>" . htmlspecialchars($row['name']) . "</h3>
                                <p class='description'>" . htmlspecialchars($row['short_description']) . "</p>
                                <p><strong>Start Date:</strong> " . htmlspecialchars($row['start_date']) . "</p>
                                <p><strong>End Date:</strong> " . htmlspecialchars($row['end_date']) . "</p>
                                <div class='button-container'>
                                    <a href='admin-event-detail.php?id=" . htmlspecialchars($row['id']) . "' class='view-btn'>View Details</a>
                                    
                                    <!-- Delete Button -->
                                    <form method='POST' onsubmit='return confirm(\"Are you sure you want to delete this event?\")'>
                                        <input type='hidden' name='delete_event_id' value='" . htmlspecialchars($row['id']) . "'>
                                        <button type='submit' class='delete-btn'>Delete</button>
                                    </form>
                                </div>
                            </div>";
                        }
                    } else {
                        echo "<p>No events found.</p>";
                    }
                    $stmt->close();
                } else {
                    echo "<p>Failed to prepare query: " . $conn->error . "</p>";
                }
            } else {
                echo "<p>Please log in to view your events.</p>";
            }
            $conn->close();
            ?>
        </div>
    </main>

    <script>
        function filterEvents() {
            var input = document.getElementById('event-name-input');
            var filter = input.value.toLowerCase();
            var eventsList = document.getElementById('events-list');
            var events = eventsList.getElementsByClassName('event-card');

            for (var i = 0; i < events.length; i++) {
                var event = events[i];
                var eventName = event.getAttribute('data-name');

                if (eventName.indexOf(filter) > -1) {
                    event.style.display = ''; // Show event if it matches the filter
                } else {
                    event.style.display = 'none'; // Hide event if it doesn't match the filter
                }
            }
        }
    </script>
</body>
</html>
