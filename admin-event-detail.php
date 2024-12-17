<?php
include 'admin-header.php'; 
include './operations/db_connection.php';

if (!isset($_SESSION['host_id'])) {
    echo "<script>alert('You are not authorized to access this page.'); window.history.back();</script>";
    exit();
}

$hostId = $_SESSION['host_id'];
$eventId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch event details
$query = "SELECT * FROM event WHERE id = ? AND host = ?";
$stmt = $conn->prepare($query);

// Check if query preparation was successful
if (!$stmt) {
    die("Query preparation failed: " . $conn->error);
}

$stmt->bind_param("ii", $eventId, $hostId);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false || $result->num_rows === 0) {
    echo "<script>alert('Event not found or you are not authorized to view it.'); window.history.back();</script>";
    exit();
}

$event = $result->fetch_assoc();

// Fetch registered students
$query = "SELECT p.id AS participant_id, u.name, p.mark 
          FROM participant p
          INNER JOIN user u ON p.participant_id = u.id
          WHERE p.event_id = ?";
$stmt = $conn->prepare($query);

// Check if query preparation was successful
if (!$stmt) {
    die("Query preparation failed: " . $conn->error);
}

$stmt->bind_param("i", $eventId);
$stmt->execute();
$students = $stmt->get_result();

// Submit marks and attendance
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST['participants'] as $participantId => $data) {
        $attendance = isset($data['attendance']) ? 1 : 0;
        $mark = $attendance ? (is_numeric($data['mark']) ? intval($data['mark']) : 0) : -1;

        $updateQuery = "UPDATE participant SET mark = ? WHERE event_id = ? AND id = ?";
        $updateStmt = $conn->prepare($updateQuery);

        if (!$updateStmt) {
            die("Query preparation failed: " . $conn->error);
        }

        $updateStmt->bind_param("iii", $mark, $eventId, $participantId);
        $updateStmt->execute();
    }
    echo "<script>alert('Attendance and marks updated successfully.'); window.location.href = 'admin-event-detail.php?id=$eventId';</script>";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link rel="stylesheet" href="./assets/css/admin-event-detail.css">
</head>
<body>
    <main class="event-detail-container">
    <?php if (!empty($event['eligibility'])): ?>
            <h2>Event Name: <span id="event-name"><?php echo htmlspecialchars($event['name']); ?></span></h2>
            <?php if (!empty($event['short_description'])): ?>
                <p class="short-description">
                    <strong>Short Description:</strong> 
                    <?php echo htmlspecialchars($event['short_description']); ?>
                </p>
            <?php endif; ?>

            <?php if (!empty($event['long_description'])): ?>
                <p class="long-description">
                    <strong>Long Description:</strong>
                    <?php echo htmlspecialchars($event['long_description']); ?>
                </p>
            <?php endif; ?>
                    <p><strong>Eligibility:</strong> <?php echo htmlspecialchars($event['eligibility']); ?></p>
                <?php endif; ?>

                <?php if (!empty($event['type'])): ?>
                    <p><strong>Type:</strong> <?php echo htmlspecialchars($event['type']); ?></p>
                <?php endif; ?>

                <?php if (!empty($event['start_date']) && !empty($event['end_date'])): ?>
                    <p><strong>Dates:</strong> <?php echo date("d-m-Y", strtotime($event['start_date'])) . " to " . date("d-m-Y", strtotime($event['end_date'])); ?></p>
                <?php endif; ?>

                <?php if (!empty($event['location'])): ?>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
                <?php endif; ?>

                <?php if (!empty($event['coordinator'])): ?>
                    <p><strong>Contact:</strong> <?php echo htmlspecialchars($event['coordinator']); ?> | <?php echo htmlspecialchars($event['coordinator_number']); ?> | <?php echo htmlspecialchars($event['coordinator_emailid']); ?></p>
                <?php endif; ?>

                <?php if (!empty($event['prize'])): ?>
                    <p><strong>Prizes:</strong> <?php echo htmlspecialchars($event['prize']); ?></p>
                <?php endif; ?>

                <?php if (!empty($event['deadline_date'])): ?>
                    <p><strong>Registration Deadline:</strong> <?php echo date("d-m-Y", strtotime($event['deadline_date'])); ?></p>
                <?php endif; ?>

                <?php if (!empty($event['website'])): ?>
                    <p><strong>Official Website:</strong> <a href="<?php echo htmlspecialchars($event['website']); ?>" target="_blank"><?php echo htmlspecialchars($event['website']); ?></a></p>
                <?php endif; ?>

        <div class="event-actions">
            <a href="admin-update-event.php?id=<?php echo $eventId; ?>" class="update-btn">Update Event</a>
            <a href="download-pdf.php?id=<?php echo $eventId; ?>" class="download-btn">Download PDF</a>
        </div>

        <h3>Registered Students</h3>
        <form method="POST">
            <table class="students-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Attendance</th>
                        <th>Marks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($student = $students->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['name']); ?></td>
                            <td>
                                <input type="checkbox" name="participants[<?php echo $student['participant_id']; ?>][attendance]"
                                    <?php echo $student['mark'] > 0 ? 'checked' : ''; ?>>
                            </td>
                            <td>
                                <input type="number" name="participants[<?php echo $student['participant_id']; ?>][mark]" 
                                    min="0" max="100" 
                                    value="<?php echo $student['mark'] > 0 ? $student['mark'] : 0; ?>">
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <button type="submit" class="submit-btn">Submit Attendance & Marks</button>
        </form>
    </main>
</body>
</html>
